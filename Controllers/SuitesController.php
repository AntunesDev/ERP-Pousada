<?php
namespace Controllers;

use Core, Models, Exception;

class SuitesController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function index()
  {
    $data = [];
    $this->loadTemplate('Suite/cadastro', $data);
  }

  public function buscarSuite()
  {
    try
    {
      $requestData = $_REQUEST;

      $Suite = new Models\Suite();
      $SuiteE = new Models\SuiteE();

      $SuiteE->ste_id = $requestData["ste_id"];
      $result = $Suite->buscarSuite($SuiteE);

      if ($result === false)
      {
        $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados da suite!"];
      }
      else
      {
        $json_data = ["success" => true, "result" => $result];
      }

      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function incluirSuite()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Suite();
      $Entity = new Models\SuiteE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["ste_tipo"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A suite não pode estar em branco.";
      }
      else if (empty($requestData["ste_valor"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O valor não pode estar em branco.";
      }
      else if (is_numeric($requestData["ste_valor"]) == false)
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um valor deve ser preenchido.";
      }
      else
      {
        $Entity->ste_tipo = $requestData["ste_tipo"];
        $Entity->ste_valor = $requestData["ste_valor"];

        $resp = $Model->cadastrarSuite($Entity);
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

  public function excluirSuite()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Suite();
      $Entity = new Models\SuiteE();

      $Entity->ste_id = $requestData["ste_id"];

      $resp = $Model->excluirSuite($Entity);
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

  public function alterarSuite()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Suite();
      $Entity = new Models\SuiteE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["ste_id"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Ocorreu um erro ao identificar a suite a ser alterado.";
      }
      else if (empty($requestData["ste_tipo"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A suite não pode estar em branco.";
      }
      else if (empty($requestData["ste_valor"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um valor deve ser preenchido.";
      }
      else if (is_numeric($requestData["ste_valor"]) == false)
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um valor deve ser preenchido.";
      }
      else
      {
        $Entity->ste_id = $requestData["ste_id"];
        $Entity->ste_tipo = $requestData["ste_tipo"];
        $Entity->ste_valor = str_replace(",", ".", $requestData["ste_valor"]);

        $resp = $Model->alterarSuite($Entity);
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

  public function consultarSuites()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Suite();

      $columns = array(
        0 => 'ste_id',
        1 => 'ste_tipo',
        2 => 'ste_valor'
      );

      $draw = $requestData['draw'];
      $search = $requestData['search']['value'];
      $order = $columns[$requestData['order'][0]['column']];
      $dir = $requestData['order'][0]['dir'];
      $start = (int) $requestData['start'];
      $length = (int) $requestData['length'];

      $totalData = count($Model->consultarSuites());
      $lSCadastro = $Model->consultarSuitesSearch($search, $order, $dir, $start, $length);

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

}