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

	public function verificarUsuario($UsuarioE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM usuarios WHERE usr_name = :usr_name;");
			$sql->bindParam(":usr_name", $UsuarioE->usrName);
			$sql->execute();
			return $sql->fetch(PDO::FETCH_OBJ);
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}
}
