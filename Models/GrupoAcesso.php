<?php
namespace Models;

use Core, Exception;
use \PDO;

class GrupoAcesso extends Core\Model
{

  	public function __construct()
	{
		parent::__construct();
	}

	public function consultarGrupos()
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM grupos_acessos;");
			$sql->execute();
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}

}
