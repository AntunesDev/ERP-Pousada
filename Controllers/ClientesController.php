<?php
namespace Controllers;

use Core, Models, Exception;

class ClientesController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->isLoggedIn();
  }

  public function index()
  {
    $data = [];
    $this->loadTemplate('Cliente/cadastro', $data);
  }

  public function consultarCliente()
  {
    try
    {
      $requestData = $_REQUEST;
      
      $Cliente = new Models\Cliente();
      $ClienteE = new Models\ClienteE();
      
      $ClienteE->cli_id = $requestData["cli_id"];
      
      $result = $Cliente->consultarCliente($ClienteE);
      if ($result === false)
      {
        $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados do cliente!"];
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

  public function consultarClienteCPF()
  {
    try
    {
      $requestData = $_REQUEST;
      
      $Cliente = new Models\Cliente();
      $ClienteE = new Models\ClienteE();

      if (!is_numeric($requestData["cli_cpf"]))
      {
        $json_data = ["success" => false, "message" => "O CPF inserido não é válido!"];
      }
      else
      {
        $ClienteE->cli_cpf = $requestData["cli_cpf"];
        
        $result = $Cliente->consultarClienteCPF($ClienteE);
        if ($result === false)
        {
          $json_data = ["success" => false, "redirect" => true];
        }
        else
        {
          array_walk_recursive($result, function(&$value)
          {
            $value = $this->Helper->removeAccents(str_replace('"', '', $value));
          });
          
          $json_data = ["success" => true, "result" => $result];
        }
      }
      
      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function incluirCliente()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Cliente();
      $Entity = new Models\ClienteE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["cli_nome"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O nome do cliente não pode estar em branco.";
      }
      else if (!is_numeric($requestData["cli_rg"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum RG válido foi inserido.";
      }
      else if (!is_numeric($requestData["cli_cpf"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum CPF válido foi inserido.";
      }
      else if (!is_numeric($requestData["cli_telefone"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum telefone válido foi inserido.";
      }
      else if (empty($requestData["cli_email"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O email não pode estar em branco.";
      }
      else
      {
        $Entity->cli_nome = $requestData["cli_nome"];
        $Entity->cli_rg = $requestData["cli_rg"];
        $Entity->cli_cpf = $requestData["cli_cpf"];
        $Entity->cli_telefone = $requestData["cli_telefone"];
        $Entity->cli_email = $requestData["cli_email"];

        $resp = $Model->cadastrarCliente($Entity);
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

  public function excluirCliente()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Cliente();
      $Entity = new Models\ClienteE();

      $Entity->cli_id = $requestData["cli_id"];

      $countReservas = $Model->consultarReservasCliente($Entity);

      if ($countReservas > 0)
      {
        $jsondata['success'] = false;
        $jsondata['message'] = "Não é possível excluir um cliente que já tenha realizado reservas anteriormente.";
      }
      else
      {
        $resp = $Model->excluirCliente($Entity);
        if ($resp === true)
        {
          $jsondata['success'] = true;
          $jsondata['message'] = "Operação realizada com sucesso.";
        }
        else
        {
          $jsondata['success'] = false;
          $jsondata['message'] = "Ocorreu um erro ao excluir o cliente selecionado.";
        }
      }

      echo json_encode($jsondata);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function alterarCliente()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Cliente();
      $Entity = new Models\ClienteE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
      });

      if (empty($requestData["cli_id"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Ocorreu um erro ao identificar o cliente a ser alterado.";
      }
      else if (empty($requestData["cli_nome"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O nome do cliente não pode estar em branco.";
      }
      else if (!is_numeric($requestData["cli_rg"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum RG válido foi inserido.";
      }
      else if (!is_numeric($requestData["cli_cpf"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum CPF válido foi inserido.";
      }
      else if (!is_numeric($requestData["cli_telefone"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Nenhum telefone válido foi inserido.";
      }
      else if (empty($requestData["cli_email"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O email não pode estar em branco.";
      }
      else
      {
        $Entity->cli_id = $requestData["cli_id"];
        $Entity->cli_nome = $requestData["cli_nome"];
        $Entity->cli_rg = $requestData["cli_rg"];
        $Entity->cli_cpf = $requestData["cli_cpf"];
        $Entity->cli_telefone = $requestData["cli_telefone"];
        $Entity->cli_email = $requestData["cli_email"];

        $resp = $Model->alterarCliente($Entity);
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

  public function consultarClientes()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Cliente();

      $columns = array(
        0 => 'cli_id',
        1 => 'cli_nome',
        2 => 'cli_rg',
        3 => 'cli_cpf',
        4 => 'cli_telefone',
        5 => 'cli_email',
        6 => 'reservas'
      );

      $draw = $requestData['draw'];
      $search = $requestData['search']['value'];
      $order = $columns[$requestData['order'][0]['column']];
      $dir = $requestData['order'][0]['dir'];
      $start = (int) $requestData['start'];
      $length = (int) $requestData['length'];

      $totalData = count($Model->consultarClientes());
      $lSCadastro = $Model->consultarClienteSearch($search, $order, $dir, $start, $length);

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

  public function listarClientes()
  {
    try
    {
      $Model = new Models\Cliente();

      $totalData = $Model->consultarClientes();
      
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