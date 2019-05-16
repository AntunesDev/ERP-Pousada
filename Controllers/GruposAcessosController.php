<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class GruposAcessosController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function consultarGrupos()
  {
    try
    {
      $Model = new Models\GrupoAcesso();
      $result = $Model->consultarGrupos();

      if (count($result) > 0)
      {
        $json_data = ["success" => true, "result" => $result];
      }
      else
      {
        $json_data = ["success" => false];
      }

      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

}