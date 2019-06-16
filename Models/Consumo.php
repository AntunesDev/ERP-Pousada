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

}
