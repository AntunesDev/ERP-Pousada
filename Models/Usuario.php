<?php
namespace Models;

use Core, Exception;
use \PDO;

class Usuario extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function verificarUsuario($UsuarioE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM usuarios WHERE usr_name = :usr_name;");
			$sql->bindParam(":usr_name", $UsuarioE->usr_name);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function incluirUsuario($UsuarioE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("INSERT INTO usuarios
			(
				usr_name,
				usr_senha,
				usr_grupo
			)
			VALUES
			(
				:usr_name,
				:usr_senha,
				:usr_grupo
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":usr_name", $UsuarioE->usr_name);
			$sql->bindParam(":usr_senha", $UsuarioE->usr_senha);
			$sql->bindParam(":usr_grupo", $UsuarioE->usr_grupo);
			$sql->execute();

			if ($sql->rowCount() <= 0)
			{
				$msg = 'Erro ao salvar dados.';
				goto end;
			}
			else
			{
				goto commit;
			}

			commit:
				$this->db->commit();
				return true;

			end:
				$this->db->rollBack();
				return $msg;
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function excluirUsuario($UsuarioE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("DELETE FROM usuarios WHERE usr_id = :usr_id;",
				array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":usr_id", $UsuarioE->usr_id);
			$sql->execute();

			return $sql->rowCount() > 0;
		}
		catch (Exception $exception)
		{
			return false;
		}
	}

	public function alterarUsuario($UsuarioE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE usuarios SET
				usr_name = :usr_name,
				usr_senha = :usr_senha,
				usr_grupo = :usr_grupo
			WHERE
				usr_id = :usr_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":usr_name", $UsuarioE->usr_name);
			$sql->bindParam(":usr_senha", $UsuarioE->usr_senha);
			$sql->bindParam(":usr_grupo", $UsuarioE->usr_grupo);
			$sql->bindParam(":usr_id", $UsuarioE->usr_id);
			$sql->execute();

			if ($sql->rowCount() <= 0)
			{
			  $msg = 'Erro ao atualizar dados.';
			  goto end;
			}
			else
			{
			  goto commit;
			}

			commit:
				$this->db->commit();
				return true;

			end:
				$this->db->rollBack();
				return $msg;
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarUsuarios()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM usuarios;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}
}
