<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class UsuariosController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function index()
  {
    $data = [];
    $this->loadTemplate('Usuario/cadastro', $data);
  }

  public function buscarUsuario()
  {
    try
    {
      $requestData = $_REQUEST;

      $Usuario = new Models\Usuario();
      $UsuarioE = new Models\UsuarioE();

      $UsuarioE->usr_id = $requestData["usr_id"];
      $result = $Usuario->buscarUsuario($UsuarioE);

      if ($result === false)
      {
        $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados do usuário!"];
      }
      else
      {
        array_walk_recursive($result, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
        });
        $json_data = ["success" => true, "result" => $result];
      }

      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
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
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
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
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
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
      $requestData = $_REQUEST;

      $Model = new Models\Usuario();

      $columns = array(
        0 => 'usr_id',
        1 => 'usr_name',
        2 => 'usr_grupo',
        3 => 'usr_nome'
      );

      $draw = $requestData['draw'];
      $search = $requestData['search']['value'];
      $order = $columns[$requestData['order'][0]['column']];
      $dir = $requestData['order'][0]['dir'];
      $start = (int) $requestData['start'];
      $length = (int) $requestData['length'];

      $totalData = count($Model->consultarUsuarios());
      $lSCadastro = $Model->consultarUsuariosSearch($search, $order, $dir, $start, $length);
      
      if ($totalData > 0)
      {
        array_walk_recursive($lSCadastro, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace('"', '', $value));
        });
      }

      if (empty($search))
      {
        $totalFiltered = $totalData;
      }
      else
      {
        $totalFiltered = count($lSCadastro);
      }

      $data = array();
      foreach ($lSCadastro as $outer_key => $array)
      {
        $nestedData = array();
        foreach($array as $inner_key => $value)
        {
          if (!(int)$inner_key)
          {
            $nestedData[$inner_key] = $value;
          }
        }
        $data[] = $nestedData;
      }

      $json_data = array(
        "draw"            => intval($draw),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "records"         => $data
      );

      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function listarUsuarios()
  {
    try
    {
      $Model = new Models\Usuario();

      $totalData = $Model->consultarUsuarios();
      
      if ($totalData > 0)
      {
        array_walk_recursive($totalData, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace('"', '', $value));
        });
        $jsondata['result'] = $totalData;
      }
      else
      {
        $jsondata['result'] = [];
      }

      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

}