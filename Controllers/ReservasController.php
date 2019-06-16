<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class ReservasController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function index()
  {
    $data = [];
    $this->loadTemplate('Reservas/index', $data);
  }

  public function getSuitesDisponiveis()
  {
    try
    {
      $requestData = $_REQUEST;
      
      $Reserva = new Models\Reserva();

      $rsv_data_entrada = $requestData["rsv_data_entrada"];
      $rsv_data_entrada = \DateTime::createFromFormat("d/m/Y", $rsv_data_entrada);
      $rsv_data_entrada = $rsv_data_entrada->format("Ymd");
      
      $rsv_data_saida = $requestData["rsv_data_saida"];
      $rsv_data_saida = \DateTime::createFromFormat("d/m/Y", $rsv_data_saida);
      $rsv_data_saida = $rsv_data_saida->format("Ymd");

      $rsv_id = empty($requestData["rsv_id"]) ? null : $requestData["rsv_id"];
      
      $result = $Reserva->getSuitesDisponiveis($rsv_data_entrada, $rsv_data_saida, $rsv_id);
      if (count($result) === 0)
      {
        $json_data = ["success" => false];
      }
      else
      {
        array_walk_recursive($result, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace('"', '', $value));
        });
        
        $json_data = ["success" => true, "list" => $result];
      }

      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function buscarReserva()
  {
    try
    {
      $requestData = $_REQUEST;

      $Reserva = new Models\Reserva();
      $ReservaE = new Models\ReservaE();

      $ReservaE->rsv_id = $requestData["rsv_id"];
      $result = $Reserva->buscarReserva($ReservaE);

      if ($result === false)
      {
        $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados da reserva!"];
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

  public function incluirReserva()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Reserva();
      $Entity = new Models\ReservaE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["rsv_data_entrada"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A data de entrada da reserva não pode estar em branco.";
      }
      else if (empty($requestData["rsv_data_saida"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A data de saída da reserva não pode estar em branco.";
      }
      else if (empty($requestData["rsv_cliente"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum cliente foi selecionado para a reserva.";
      }
      else if (empty($requestData["rsv_suite"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma suíte foi selecionada para a reserva.";
      }
      else
      {
        $Entity->rsv_data_entrada = $requestData["rsv_data_entrada"];
        $Entity->rsv_data_entrada = \DateTime::createFromFormat("d/m/Y", $Entity->rsv_data_entrada);
        $Entity->rsv_data_entrada = $Entity->rsv_data_entrada->format("Ymd");
        
        $Entity->rsv_data_saida = $requestData["rsv_data_saida"];
        $Entity->rsv_data_saida = \DateTime::createFromFormat("d/m/Y", $Entity->rsv_data_saida);
        $Entity->rsv_data_saida = $Entity->rsv_data_saida->format("Ymd");

        $Entity->rsv_status = 1;
        $Entity->rsv_cliente = $requestData["rsv_cliente"];
        $Entity->rsv_funcionario = $_SESSION[$this->Config::SESSION_NAME]["user"]["data"]["id"];
        $Entity->rsv_suite = $requestData["rsv_suite"];

        $resp = $Model->incluirReserva($Entity);
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

  public function cancelarReserva()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Reserva();
      $Entity = new Models\ReservaE();

      $Entity->rsv_id = $requestData["rsv_id"];

      $reserva = $Model->buscarReserva($Entity);

      if ($reserva == false)
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Ocorreu um erro ao buscar informações da reserva.";
      }
      else if ($reserva->rsv_status == 3)
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Não é possível cancelar uma reserva em andamento. Em vez disso, faça o checkout.";
      }
      else if ($reserva->rsv_status == 4)
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Não é possível cancelar uma reserva já aguardando checkout.";
      }
      else
      {
        $resp = $Model->cancelarReserva($Entity);
        if ($resp === true)
        {
          $jsondata['success'] = true;
          $jsondata['message'] = "Operação realizada com sucesso.";
        }
        else
        {
          $jsondata['success'] = false;
          $jsondata['message'] = "Ocorreu um erro ao cancelar a reserva selecionada.";
        }
      }

      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function alterarReserva()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Reserva();
      $Entity = new Models\ReservaE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["rsv_data_entrada"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A data de entrada da reserva não pode estar em branco.";
      }
      else if (empty($requestData["rsv_data_saida"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "A data de saída da reserva não pode estar em branco.";
      }
      else if (empty($requestData["rsv_cliente"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum cliente foi selecionado para a reserva.";
      }
      else if (empty($requestData["rsv_suite"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhuma suíte foi selecionada para a reserva.";
      }
      else
      {
        $Entity->rsv_data_entrada = $requestData["rsv_data_entrada"];
        $Entity->rsv_data_entrada = \DateTime::createFromFormat("d/m/Y", $Entity->rsv_data_entrada);
        $Entity->rsv_data_entrada = $Entity->rsv_data_entrada->format("Ymd");
        
        $Entity->rsv_data_saida = $requestData["rsv_data_saida"];
        $Entity->rsv_data_saida = \DateTime::createFromFormat("d/m/Y", $Entity->rsv_data_saida);
        $Entity->rsv_data_saida = $Entity->rsv_data_saida->format("Ymd");

        
        $Entity->rsv_id = $requestData["rsv_id"];
        $Entity->rsv_cliente = $requestData["rsv_cliente"];
        $Entity->rsv_suite = $requestData["rsv_suite"];
        
        $resp = $Model->alterarReserva($Entity);
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

  public function alterarEstadoReserva()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Reserva();
      $Entity = new Models\ReservaE();

      $Entity->rsv_id = $requestData["rsv_id"];
      $Entity->rsv_status = $requestData["rsv_status_to"];

      if ($requestData["rsv_status_from"] == 3)
      {
        $Model->adiantarCheckoutReserva($Entity);
      }

      $resp = $Model->alterarEstadoReserva($Entity);
      if ($resp === true)
      {
        $jsondata['success'] = true;
        $jsondata['message'] = "Operação realizada com sucesso.";

        if ($requestData["rsv_status_to"] == 5)
        {
          $Consumo = new Models\Consumo();
          $consumoTotalReserva = $Consumo->getConsumoTotalReserva($Entity);
          $totalReserva = $Model->getTotalReserva($Entity);

          $consumoTotalReserva[] = [
            "cns_produto" => $totalReserva->rsv_suite,
            "cns_qtde" => $totalReserva->rsv_dias,
            "cns_valor" => $totalReserva->rsv_valor_dia,
            "cns_valor_total" => $totalReserva->rsv_valor_total
          ];

          array_walk_recursive($requestData, function(&$value, $key)
          {
            if ($key == "cns_valor" || $key == "cns_valor_total")
            {
              $value = number_format($value, 2, ",", ".");
            }
            else
            {
              $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
            }
          });

          $total = 0;
          foreach ($consumoTotalReserva as $produto)
          {
            $total += $produto["cns_valor_total"];
          }
          $total = number_format($total, 2, ",", ".");

          $jsondata['itens'] = $consumoTotalReserva;
          $jsondata['valor_total'] = $total;
        }
      }
      else
      {
        $jsondata['success'] = false;
        $jsondata['message'] = $resp;
      }
      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function consultarReservas()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Reserva();
      $Model->atualizaEstadoReservas();

      $columns = array(
        0 => 'rsv_id',
        1 => 'rsv_data_entrada',
        2 => 'rsv_data_saida',
        3 => 'ste_tipo',
        4 => 'sst_nome',
        5 => 'cli_nome',
        6 => 'fnc_nome',
        7 => 'rsv_valor_total'
      );

      $draw = $requestData['draw'];
      $search = $requestData['search']['value'];
      $order = $columns[$requestData['order'][0]['column']];
      $dir = $requestData['order'][0]['dir'];
      $start = (int) $requestData['start'];
      $length = (int) $requestData['length'];

      $totalData = count($Model->consultarReservas());
      $lSCadastro = $Model->consultarReservasSearch($search, $order, $dir, $start, $length);
      
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