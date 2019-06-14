<?php
namespace Models;

use Core, Exception;
use \PDO;

class Suite extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function cadastrarSuite($SuiteE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("INSERT INTO suites
			(
				ste_tipo,
				ste_valor
			)
			VALUES
			(
				:ste_tipo,
				:ste_valor
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":ste_tipo", $SuiteE->ste_tipo);
			$sql->bindParam(":ste_valor", $SuiteE->ste_valor);
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

	public function buscarSuite($SuiteE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM suites WHERE ste_id = :ste_id;");
			$sql->bindParam(":ste_id", $SuiteE->ste_id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function alterarSuite($SuiteE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE suites SET
				ste_tipo = :ste_tipo,
				ste_valor = :ste_valor
			WHERE
				ste_id = :ste_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":ste_tipo", $SuiteE->ste_tipo);
			$sql->bindParam(":ste_valor", $SuiteE->ste_valor);
			$sql->bindParam(":ste_id", $SuiteE->ste_id);
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

	public function excluirSuite($SuiteE)
	{
		try
		{
			$sql = $this->db->prepare("DELETE FROM suites WHERE ste_id = :ste_id;",
				array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":ste_id", $SuiteE->ste_id);
			$sql->execute();

			return $sql->rowCount() > 0;
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarSuites()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM suites;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarSuitesSearch($searchText, $orderColumn, $orderDir, $start, $rows)
	{
		if(is_numeric($rows) == false)
			die();

		$strSQL = "SELECT
			ste_id,
			ste_tipo,
			ste_valor
		FROM suites
		WHERE
			ste_tipo LIKE :searchText
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
