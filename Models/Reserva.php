<?php
namespace Models;

use Core, Exception;
use \PDO;

class Reserva extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function getSuitesDisponiveis($dataInicio, $dataFim, $rsv_id)
	{
		try
		{
			$sql = $this->db->prepare("SELECT
				*
			FROM
				suites
			WHERE
				ste_id NOT IN (
					SELECT
						rsv_suite
					FROM
						reservas
					WHERE
						(
							rsv_data_entrada BETWEEN :dataInicio
							AND :dataFim
							OR rsv_data_saida BETWEEN :dataInicio
							AND :dataFim
						)
					AND rsv_status < 5
					".($rsv_id != null ? "AND rsv_id != :rsv_id" : "")."
				);");
			
			$sql->bindParam(":dataInicio", $dataInicio);
			$sql->bindParam(":dataFim", $dataFim);

			if ($rsv_id != null)
			{
				$sql->bindParam(":rsv_id", $rsv_id);
			}

			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function buscarReserva($ReservaE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT 
				rsv_id,
				DATE_FORMAT(rsv_data_entrada, \"%d/%m/%Y\") AS rsv_data_entrada,
				DATE_FORMAT(rsv_data_saida, \"%d/%m/%Y\") AS rsv_data_saida,
				rsv_status,
				rsv_cliente,
				rsv_funcionario,
				rsv_suite 
			FROM reservas 
			WHERE rsv_id = :rsv_id;");
			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function incluirReserva($ReservaE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("INSERT INTO reservas
			(
				rsv_data_entrada,
				rsv_data_saida,
				rsv_status,
				rsv_cliente,
				rsv_funcionario,
				rsv_suite
			)
			VALUES
			(
				:rsv_data_entrada,
				:rsv_data_saida,
				:rsv_status,
				:rsv_cliente,
				:rsv_funcionario,
				:rsv_suite
			)
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":rsv_data_entrada", $ReservaE->rsv_data_entrada);
			$sql->bindParam(":rsv_data_saida", $ReservaE->rsv_data_saida);
			$sql->bindParam(":rsv_status", $ReservaE->rsv_status);
			$sql->bindParam(":rsv_cliente", $ReservaE->rsv_cliente);
			$sql->bindParam(":rsv_funcionario", $ReservaE->rsv_funcionario);
			$sql->bindParam(":rsv_suite", $ReservaE->rsv_suite);

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

	public function cancelarReserva($ReservaE)
	{
		try
		{
			$sql = $this->db->prepare("UPDATE reservas SET rsv_status = 6 WHERE rsv_id = :rsv_id;",
				array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
			$sql->execute();

			return $sql->rowCount() > 0;
		}
		catch (Exception $exception)
		{
			return false;
		}
	}

	public function alterarReserva($ReservaE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE reservas SET
				rsv_data_entrada = :rsv_data_entrada,
				rsv_data_saida = :rsv_data_saida,
				rsv_cliente = :rsv_cliente,
				rsv_suite = :rsv_suite
			WHERE
				rsv_id = :rsv_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":rsv_data_entrada", $ReservaE->rsv_data_entrada);
			$sql->bindParam(":rsv_data_saida", $ReservaE->rsv_data_saida);
			$sql->bindParam(":rsv_cliente", $ReservaE->rsv_cliente);
			$sql->bindParam(":rsv_suite", $ReservaE->rsv_suite);
			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
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

	public function adiantarCheckoutReserva($ReservaE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE reservas SET
				rsv_data_saida = CURDATE()
			WHERE
				rsv_id = :rsv_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
			$sql->execute();

			if ($sql->rowCount() <= 0)
			{
			  $msg = 'Erro ao adiantar checkout da reserva.';
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

	public function alterarEstadoReserva($ReservaE)
	{
		$this->db->beginTransaction();
		try
		{
			$sql = $this->db->prepare("UPDATE reservas SET
				rsv_status = :rsv_status
			WHERE
				rsv_id = :rsv_id
			", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			$sql->bindParam(":rsv_status", $ReservaE->rsv_status);
			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
			$sql->execute();

			if ($sql->rowCount() <= 0)
			{
			  $msg = 'Erro ao atualizar estado da reserva.';
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

	public function atualizaEstadoReservas()
	{
		try 
		{
			$sql = $this->db->prepare("UPDATE reservas SET rsv_status = 2 
			WHERE rsv_data_entrada = CURDATE()
			AND rsv_status = 1;");
			$sql->execute();

			$sql = $this->db->prepare("UPDATE reservas SET rsv_status = 6 
			WHERE rsv_data_entrada < CURDATE()
			AND (rsv_status = 1 OR rsv_status = 2);");
			$sql->execute();

			$sql = $this->db->prepare("UPDATE reservas SET rsv_status = 4 
			WHERE rsv_data_saida = CURDATE()
			AND rsv_status = 3;");
			$sql->execute();
		}
		catch (Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarReservas()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM reservas WHERE rsv_status < 5;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

	public function consultarReservasSearch($searchText, $orderColumn, $orderDir, $start, $rows)
	{
		if(is_numeric($rows) == false)
			die();

		$strSQL = "SELECT
			rsv_id,
			DATE_FORMAT(rsv_data_entrada, \"%d/%m/%Y\") AS rsv_data_entrada,
			DATE_FORMAT(rsv_data_saida, \"%d/%m/%Y\") AS rsv_data_saida,
			rsv_status,
			sst_nome,
			rsv_cliente,
			cli_nome,
			rsv_funcionario,
			fnc_nome,
			rsv_suite,
			ste_tipo,
			(
				((CASE WHEN DATEDIFF(rsv_data_saida, rsv_data_entrada) = 0 THEN 1 ELSE DATEDIFF(rsv_data_saida, rsv_data_entrada) END) * ste_valor)
				+
				(SELECT CASE WHEN SUM(cns_valor * cns_qtde) IS NULL THEN 0 ELSE SUM(cns_valor * cns_qtde) END FROM consumo WHERE cns_reserva = rsv_id)
			) AS rsv_valor_total
		FROM reservas
		LEFT JOIN suites_status ON sst_id = rsv_status
		LEFT JOIN clientes ON cli_id = rsv_cliente
		LEFT JOIN suites ON ste_id = rsv_suite
		LEFT JOIN funcionarios ON fnc_id = rsv_funcionario
		WHERE
			(rsv_suite LIKE :searchText
			OR fnc_nome LIKE :searchText
			OR cli_nome LIKE :searchText
			OR sst_nome LIKE :searchText)
		AND
			rsv_status < 5	
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

	public function getTotalReserva($ReservaE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT
				CASE WHEN DATEDIFF(rsv_data_saida, rsv_data_entrada) = 0 THEN 1 ELSE DATEDIFF(rsv_data_saida, rsv_data_entrada) END AS rsv_dias,
				ste_valor AS rsv_valor_dia,
				((CASE WHEN DATEDIFF(rsv_data_saida, rsv_data_entrada) = 0 THEN 1 ELSE DATEDIFF(rsv_data_saida, rsv_data_entrada) END) * ste_valor) AS rsv_valor_total,
				ste_tipo AS rsv_suite
			FROM reservas 
			LEFT JOIN suites ON ste_id = rsv_suite
			WHERE rsv_id = :rsv_id;");
			$sql->bindParam(":rsv_id", $ReservaE->rsv_id);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

}
