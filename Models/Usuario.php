<?php
namespace Models;

use Core;
use \PDO;

class Usuario extends Core\Model
{

private $usuario;

  	public function __construct()
	{
		parent::__construct();
	}

	public function getUsuario($UsuarioE)
	{
		try
		{
			$sql = $this->db->prepare("SELECT * FROM nt_SenhaCad 
					WHERE senUsuario = :usuario AND senSenha = :senha");
			$sql->bindParam(":usuario", $UsuarioE->senUsuario);
			$sql->bindParam(":senha", $UsuarioE->senSenha);
			$sql->execute();

			$this->usuario = $sql->fetch(PDO::FETCH_OBJ);

			return $this->usuario;
		}
		catch(Exception $exception)
		{
			throw new Exception($exception, 500);
		}
	}
}
