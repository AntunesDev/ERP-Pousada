<?php
namespace Models;

use Core, Exception;
use \PDO;

class Cliente extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function cadastrarCliente($ClienteE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("INSERT INTO clientes
			(
				cli_nome,
				cli_rg,
				cli_cpf,
				cli_telefone,
				cli_email
			)
			VALUES
			(
				:cli_nome,
				:cli_rg,
				:cli_cpf,
				:cli_telefone,
				:cli_email
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":cli_nome", $ClienteE->cli_nome);
			$sql->bindParam(":cli_rg", $ClienteE->cli_rg);
			$sql->bindParam(":cli_cpf", $ClienteE->cli_cpf);
			$sql->bindParam(":cli_telefone", $ClienteE->cli_telefone);
			$sql->bindParam(":cli_email", $ClienteE->cli_email);
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

	public function consultarCliente($ClienteE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM clientes WHERE cli_id = :cli_id;");
			$sql->bindParam(":cli_id", $ClienteE->cli_id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function alterarCliente($ClienteE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE clientes SET
				cli_nome = :cli_nome,
				cli_rg = :cli_rg,
				cli_cpf = :cli_cpf,
				cli_telefone = :cli_telefone,
				cli_email = :cli_email
			WHERE
				cli_id = :cli_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":cli_nome", $ClienteE->cli_nome);
			$sql->bindParam(":cli_rg", $ClienteE->cli_rg);
			$sql->bindParam(":cli_cpf", $ClienteE->cli_cpf);
			$sql->bindParam(":cli_telefone", $ClienteE->cli_telefone);
			$sql->bindParam(":cli_email", $ClienteE->cli_email);
			$sql->bindParam(":cli_id", $ClienteE->cli_id);
			$sql->execute();

			if ($sql->rowCount() < 0)
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

	public function excluirCliente($ClienteE)
	{
		try
		{
			$sql = $this->db->prepare("DELETE FROM clientes WHERE cli_id = :cli_id;",
				array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":cli_id", $ClienteE->cli_id);
			$sql->execute();

			return $sql->rowCount() > 0;
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarClientes()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM clientes;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarClienteSearch($searchText, $orderColumn, $orderDir, $start, $rows)
	{
		if(is_numeric($rows) == false)
			die();

		$strSQL = "SELECT
			cli_id,
			cli_nome,
			cli_rg,
			cli_cpf,
			cli_telefone,
			cli_email
		FROM clientes
		WHERE
			cli_nome LIKE :searchText
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
