<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class UsuarioController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function index()
  {
    $data = [];
    $this->loadTemplate('Home/home', $data);
  }

  public function incluirUsuario()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Usuario();
      $Entity = new Models\UsuarioE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], utf8_encode($value)));
      });

      if (empty($requestData["usr_name"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O usuário não pode estar em branco.";
      }
      else if (empty($requestData["usr_senha"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A senha não pode estar em branco.";
      }
      else if (empty($requestData["usr_grupo"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um grupo de acessos deve ser selecionado.";
      }
      else
      {
        $Entity->usr_name = $requestData["usr_name"];
        $Entity->usr_senha = password_hash($requestData["usr_senha"], PASSWORD_BCRYPT);
        $Entity->usr_grupo = $requestData["usr_grupo"];

        $resp = $Model->incluirUsuario($Entity);
        if ($resp === true)
        {
          $jsondata['success'] = true;
          $jsondata['message'] = "Operação realizada com sucesso.";
        }
        else
        {
          $jsondata['success'] = false;
          $jsondata['message'] = $resp;
        }
      }
      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function excluirUsuario()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Usuario();
      $Entity = new Models\UsuarioE();

      $Entity->usr_id = $requestData["usr_id"];

      $resp = $Model->excluirUsuario($Entity);
      if ($resp === true)
      {
        $jsondata['success'] = true;
        $jsondata['message'] = "Operação realizada com sucesso.";
      }
      else
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Ocorreu um erro ao excluir o usuário selecionado.";
      }
      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function alterarUsuario()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Usuario();
      $Entity = new Models\UsuarioE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], utf8_encode($value)));
      });

      if (empty($requestData["usr_id"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Ocorreu um erro ao identificar o usuário a ser alterado.";
      }
      else if (empty($requestData["usr_name"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O usuário não pode estar em branco.";
      }
      else if (empty($requestData["usr_senha"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A senha não pode estar em branco.";
      }
      else if (empty($requestData["usr_grupo"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um grupo de acessos deve ser selecionado.";
      }
      else
      {
        $Entity->usr_id = $requestData["usr_id"];
        $Entity->usr_name = $requestData["usr_name"];
        $Entity->usr_senha = password_hash($requestData["usr_senha"], PASSWORD_BCRYPT);
        $Entity->usr_grupo = $requestData["usr_grupo"];

        $resp = $Model->alterarUsuario($Entity);
        if ($resp === true)
        {
          $jsondata['success'] = true;
          $jsondata['message'] = "Operação realizada com sucesso.";
        }
        else
        {
          $jsondata['success'] = false;
          $jsondata['message'] = $resp;
        }
      }
      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function consultarUsuarios()
  {
    try
    {
      $Model = new Models\Usuario();

      $result = $Model->consultarUsuarios();
      if (count($result) > 0)
      {
        $jsondata['success'] = true;
        $jsondata['result'] = $result;
      }
      else
      {
        $jsondata['success'] = false;
      }
      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

}