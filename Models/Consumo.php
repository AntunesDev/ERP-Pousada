<?php
namespace Models;

use Core, Exception;
use \PDO;

class Consumo extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function getConsumoTotalReserva($ReservaE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT
				prd_descricao AS cns_produto,
				cns_qtde,
				cns_valor,
				(cns_qtde * cns_valor) AS cns_valor_total
			FROM consumo 
			LEFT JOIN produtos ON prd_id = cns_produto
			WHERE cns_reserva = :rsv_id;");
			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function cadastrarConsumo($ConsumoE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("INSERT INTO consumo
			(
				cns_produto,
				cns_reserva,
				cns_valor,
				cns_momento,
				cns_qtde
			)
			VALUES
			(
				:cns_produto,
				:cns_reserva,
				:cns_valor,
				CURRENT_TIMESTAMP(),
				:cns_qtde
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":cns_produto", $ConsumoE->cns_produto);
			$sql->bindParam(":cns_reserva", $ConsumoE->cns_reserva);
			$sql->bindParam(":cns_valor", $ConsumoE->cns_valor);
			$sql->bindParam(":cns_qtde", $ConsumoE->cns_qtde);
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

	public function buscarConsumo($ConsumoE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM consumo WHERE 
			cns_produto = :cns_produto AND cns_reserva = :cns_reserva;");

			$sql->bindParam(":cns_produto", $ConsumoE->cns_produto);
			$sql->bindParam(":cns_reserva", $ConsumoE->cns_reserva);

			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function alterarConsumo($ConsumoE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE consumo SET
				cns_valor = :cns_valor,
				cns_qtde = :cns_qtde
			WHERE
				cns_produto = :cns_produto
				AND cns_reserva = :cns_reserva
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":cns_valor", $ConsumoE->cns_valor);
			$sql->bindParam(":cns_qtde", $ConsumoE->cns_qtde);
			$sql->bindParam(":cns_produto", $ConsumoE->cns_produto);
			$sql->bindParam(":cns_reserva", $ConsumoE->cns_reserva);
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

	public function excluirConsumo($ConsumoE)
	{
		try
		{
			$sql = $this->db->prepare("DELETE FROM consumo WHERE 
			cns_produto = :cns_produto AND cns_reserva = :cns_reserva;",
			array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":cns_produto", $ConsumoE->cns_produto);
			$sql->bindParam(":cns_reserva", $ConsumoE->cns_reserva);
			$sql->execute();

			return $sql->rowCount() > 0;
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarConsumos($cns_reserva)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM consumo WHERE cns_reserva = :cns_reserva;");
			$sql->bindParam(":cns_reserva", $cns_reserva);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarConsumosSearch($cns_reserva, $searchText, $orderColumn, $orderDir, $start, $rows)
	{
		if(is_numeric($rows) == false)
			die();

		$strSQL = "SELECT
			cns_produto,
			prd_descricao,
			cns_valor,
			cns_qtde,
			cns_valor * cns_qtde AS cns_valor_total,
			DATE_FORMAT(cns_momento, \"%d/%m/%Y - %H:%i:%s\") AS cns_momento
		FROM consumo
		LEFT JOIN produtos ON prd_id = cns_produto
		WHERE
			cns_reserva = :cns_reserva
			AND prd_descricao LIKE :searchText
		ORDER BY ".$orderColumn." ".$orderDir."
		LIMIT :start, :rows;";
		
		$sql = $this->db->prepare($strSQL);

		if(empty($searchText))
			$searchText = '%';
		else
			$searchText = '%'.$searchText.'%';

		$sql->bindParam(":cns_reserva", $cns_reserva);
		$sql->bindParam(":searchText", $searchText);
		$sql->bindParam(":start", $start, PDO::PARAM_INT);
		$sql->bindParam(":rows", $rows, PDO::PARAM_INT);
		$sql->execute();

		$row = $sql->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

}
