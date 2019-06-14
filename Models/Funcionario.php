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
			$sql = $this->db->prepare("INSERT INTO funcionarios
			(
				fnc_nome,
				fnc_rg,
				fnc_cpf,
				fnc_telefone,
				fnc_email,
				fnc_endereco,
				fnc_cep,
				fnc_cidade,
				fnc_funcao,
				fnc_salario,
				fnc_usuario
			)
			VALUES
			(
				:fnc_nome,
				:fnc_rg,
				:fnc_cpf,
				:fnc_telefone,
				:fnc_email,
				:fnc_endereco,
				:fnc_cep,
				:fnc_cidade,
				:fnc_funcao,
				:fnc_salario,
				:fnc_usuario
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":fnc_nome", $FuncionarioE->fnc_nome);
			$sql->bindParam(":fnc_rg", $FuncionarioE->fnc_rg);
			$sql->bindParam(":fnc_cpf", $FuncionarioE->fnc_cpf);
			$sql->bindParam(":fnc_telefone", $FuncionarioE->fnc_telefone);
			$sql->bindParam(":fnc_email", $FuncionarioE->fnc_email);
			$sql->bindParam(":fnc_endereco", $FuncionarioE->fnc_endereco);
			$sql->bindParam(":fnc_cep", $FuncionarioE->fnc_cep);
			$sql->bindParam(":fnc_cidade", $FuncionarioE->fnc_cidade);
			$sql->bindParam(":fnc_funcao", $FuncionarioE->fnc_funcao);
			$sql->bindParam(":fnc_salario", $FuncionarioE->fnc_salario);
			$sql->bindParam(":fnc_usuario", $FuncionarioE->fnc_usuario);
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
			$sql = $this->db->prepare("SELECT * FROM funcionarios WHERE fnc_id = :fnc_id;");
			$sql->bindParam(":fnc_id", $FuncionarioE->fnc_id);
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
			$sql = $this->db->prepare("UPDATE funcionarios SET
				fnc_nome = :fnc_nome,
				fnc_rg = :fnc_rg,
				fnc_cpf = :fnc_cpf,
				fnc_telefone = :fnc_telefone,
				fnc_email = :fnc_email,
				fnc_endereco = :fnc_endereco,
				fnc_cep = :fnc_cep,
				fnc_cidade = :fnc_cidade,
				fnc_funcao = :fnc_funcao,
				fnc_salario = :fnc_salario,
				fnc_usuario = :fnc_usuario
			WHERE
				fnc_id = :fnc_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":fnc_nome", $FuncionarioE->fnc_nome);
			$sql->bindParam(":fnc_rg", $FuncionarioE->fnc_rg);
			$sql->bindParam(":fnc_cpf", $FuncionarioE->fnc_cpf);
			$sql->bindParam(":fnc_telefone", $FuncionarioE->fnc_telefone);
			$sql->bindParam(":fnc_email", $FuncionarioE->fnc_email);
			$sql->bindParam(":fnc_endereco", $FuncionarioE->fnc_endereco);
			$sql->bindParam(":fnc_cep", $FuncionarioE->fnc_cep);
			$sql->bindParam(":fnc_cidade", $FuncionarioE->fnc_cidade);
			$sql->bindParam(":fnc_funcao", $FuncionarioE->fnc_funcao);
			$sql->bindParam(":fnc_salario", $FuncionarioE->fnc_salario);
			$sql->bindParam(":fnc_usuario", $FuncionarioE->fnc_usuario);
			$sql->bindParam(":fnc_id", $FuncionarioE->fnc_id);
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
			$sql = $this->db->prepare("DELETE FROM funcionarios WHERE fnc_id = :fnc_id;",
				array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":fnc_id", $FuncionarioE->fnc_id);
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
			fnc_id,
			fnc_nome,
			fnc_rg,
			fnc_cpf,
			fnc_telefone,
			fnc_email,
			fnc_endereco,
			fnc_cep,
			fnc_cidade,
			fnc_funcao,
			fnc_salario,
			fnc_usuario
		FROM funcionarios
		WHERE
			fnc_nome LIKE :searchText
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
