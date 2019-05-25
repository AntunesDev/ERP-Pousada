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

	public function buscarUsuario($UsuarioE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT usr_id, usr_name, usr_grupo FROM usuarios WHERE usr_id = :usr_id;");
			$sql->bindParam(":usr_id", $UsuarioE->usr_id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
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
			$sql = $this->db->prepare("SELECT * FROM usuarios JOIN grupos_acessos ON grp_id = usr_grupo LEFT JOIN funcionarios ON fnc_usuario = usr_id WHERE usr_id <> 1;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarUsuariosSearch($searchText, $orderColumn, $orderDir, $start, $rows)
	{
		if(is_numeric($rows) == false)
			die();

		$strSQL = "SELECT
			usr_id,
			usr_name,
			grp_nome AS usr_grupo,
			fnc_nome AS usr_nome
		FROM usuarios
		JOIN grupos_acessos ON grp_id = usr_grupo
		LEFT JOIN funcionarios ON fnc_usuario = usr_id
		WHERE
			usr_id <> 1
			AND (
				usr_name LIKE :searchText
				OR fnc_nome LIKE :searchText
			)
		ORDER BY ".$orderColumn." ".$orderDir."
		LIMIT :start, :rows;";
		
		$sql = $this->db->prepare($strSQL);

		if(empty($searchText))
			$searchText = '%';
		else
			$searchText = '%'.$searchText.'%';

		$sql->bindParam(":searchText", $searchText);
		$sql->bindParam(":start", $start, PDO::PARAM_INT);
		$sql->bindParam(":rows", $rows, PDO::PARAM_INT);
		$sql->execute();

		$row = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
}
