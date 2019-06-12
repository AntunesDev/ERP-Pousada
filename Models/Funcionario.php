<?php
namespace Models;

use Core, Exception;
use \PDO;

class Funcionario extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function cadastrarFuncionario($FuncionarioE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("INSERT INTO produtos
			(
				prd_descricao,
				prd_valor
			)
			VALUES
			(
				:prd_descricao,
				:prd_valor
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":prd_descricao", $FuncionarioE->prd_descricao);
			$sql->bindParam(":prd_valor", $FuncionarioE->prd_valor);
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

	public function consultarFuncionario($FuncionarioE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM funcionarios WHERE prd_id = :prd_id;");
			$sql->bindParam(":prd_id", $FuncionarioE->prd_id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function alterarFuncionario($FuncionarioE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE produtos SET
				prd_descricao = :prd_descricao,
				prd_valor = :prd_valor
			WHERE
				prd_id = :prd_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":prd_descricao", $FuncionarioE->prd_descricao);
			$sql->bindParam(":prd_valor", $FuncionarioE->prd_valor);
			$sql->bindParam(":prd_id", $FuncionarioE->prd_id);
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

	public function excluirFuncionario($FuncionarioE)
	{
		try
		{
			$sql = $this->db->prepare("DELETE FROM funcionarios WHERE prd_id = :prd_id;",
				array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":prd_id", $FuncionarioE->prd_id);
			$sql->execute();

			return $sql->rowCount() > 0;
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarFuncionarios()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM funcionarios;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarFuncionarioSearch($searchText, $orderColumn, $orderDir, $start, $rows)
	{
		if(is_numeric($rows) == false)
			die();

		$strSQL = "SELECT
			prd_id,
			prd_descricao,
			prd_valor
		FROM funcionarios
		WHERE
			prd_descricao LIKE :searchText
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

	public function gerarRelProd()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM funcionarios;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

}
