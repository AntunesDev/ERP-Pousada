<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class ConsumoController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function index()
  {
    $requestData = $_REQUEST;
    $rsv_id = $requestData["rsv_id"] ?? null;

    $data = ["rsv_id" => $rsv_id];
    $this->loadTemplate('Consumo/index', $data);
  }

  public function buscarConsumo()
  {
    try
    {
      $requestData = $_REQUEST;

      $Consumo = new Models\Consumo();
      $ConsumoE = new Models\ConsumoE();

      $ConsumoE->cns_produto = $requestData["cns_produto"];
      $ConsumoE->cns_reserva = $requestData["cns_reserva"];
      $result = $Consumo->buscarConsumo($ConsumoE);

      if ($result === false)
      {
        $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados do consumo!"];
      }
      else
      {
        array_walk_recursive($result, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace('"', '', $value));
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

  public function incluirConsumo()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Consumo();
      $Entity = new Models\ConsumoE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["cns_produto"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum produto válido foi selecionado.";
      }
      else if (empty($requestData["cns_reserva"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma reserva foi selecionada.";
      }
      else if (empty($requestData["cns_valor"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Não é possível selecionar um produto sem valor preenchido.";
      }
      else if (is_numeric($requestData["cns_valor"]) == false)
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Não é possível selecionar um produto sem valor válido preenchido.";
      }
      else if (empty($requestData["cns_qtde"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma quantidade foi preenchida.";
      }
      else if (is_numeric($requestData["cns_qtde"]) == false)
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma quantidade válida foi preenchida.";
      }
      else
      {
        $Entity->cns_produto = $requestData["cns_produto"];
        $Entity->cns_reserva = $requestData["cns_reserva"];
        $Entity->cns_valor = $requestData["cns_valor"];
        $Entity->cns_qtde = $requestData["cns_qtde"];

        $resp = $Model->cadastrarConsumo($Entity);
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

  public function excluirConsumo()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Consumo();
      $Entity = new Models\ConsumoE();

      $Entity->cns_produto = $requestData["cns_produto"];
      $Entity->cns_reserva = $requestData["cns_reserva"];

      $resp = $Model->excluirConsumo($Entity);
      if ($resp === true)
      {
        $jsondata['success'] = true;
        $jsondata['message'] = "Operação realizada com sucesso.";
      }
      else
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Ocorreu um erro ao excluir o consumo selecionado.";
      }
      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function alterarConsumo()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Consumo();
      $Entity = new Models\ConsumoE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["cns_produto"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum produto válido foi selecionado.";
      }
      else if (empty($requestData["cns_reserva"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma reserva foi selecionada.";
      }
      else if (empty($requestData["cns_valor"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Não é possível selecionar um produto sem valor preenchido.";
      }
      else if (is_numeric($requestData["cns_valor"]) == false)
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Não é possível selecionar um produto sem valor válido preenchido.";
      }
      else if (empty($requestData["cns_qtde"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma quantidade foi preenchida.";
      }
      else if (is_numeric($requestData["cns_qtde"]) == false)
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma quantidade válida foi preenchida.";
      }
      else
      {
        $Entity->cns_produto = $requestData["cns_produto"];
        $Entity->cns_reserva = $requestData["cns_reserva"];
        $Entity->cns_valor = $requestData["cns_valor"];
        $Entity->cns_qtde = $requestData["cns_qtde"];

        $result = $Model->buscarConsumo($Entity);

        if ($result === false)
        {
          $resp = $Model->cadastrarConsumo($Entity);
        }
        else
        {
          $resp = $Model->alterarConsumo($Entity);
        }

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

  public function consultarConsumos()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Consumo();

      $columns = array(
        0 => 'cns_produto',
        1 => 'prd_descricao',
        2 => 'cns_valor',
        3 => 'cns_qtde',
        4 => 'cns_valor_total',
        5 => 'cns_momento'
      );

      $draw = $requestData['draw'];
      $search = $requestData['search']['value'];
      $order = $columns[$requestData['order'][0]['column']];
      $dir = $requestData['order'][0]['dir'];
      $start = (int) $requestData['start'];
      $length = (int) $requestData['length'];

      $postData = $requestData["postData"];
      $cns_reserva = $postData["cns_reserva"];

      $totalData = count($Model->consultarConsumos($cns_reserva));
      $lSCadastro = $Model->consultarConsumosSearch($cns_reserva, $search, $order, $dir, $start, $length);

      if ($totalData > 0)
      {
        array_walk_recursive($lSCadastro, function(&$value, $key)
        {
          if ($key == "cns_valor" || $key == "cns_valor_total")
          {
            $value = "R$ ".number_format($value, 2, ",", ".");
          }
          else
          {
            $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
          }
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