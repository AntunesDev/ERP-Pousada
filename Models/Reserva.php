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

	public function consultarSuitesDisponíveis($dataInicio, $dataFim)
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
				);");
			
			$sql->bindParam(":dataInicio", $dataInicio);
			$sql->bindParam(":dataFim", $dataFim);
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

}
