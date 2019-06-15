<?php
  namespace Controllers;

  use Core, Models, Exception;
  use Core\Config;

  class FuncionariosController extends Core\Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->isLoggedIn();
    }

    public function index()
    {
      $data = [];
      $this->loadTemplate('Funcionario/cadastro', $data);
    }
    
    public function consultarFuncionario()
    {
      try
      {
        $requestData = $_REQUEST;
        
        $Funcionario = new Models\Funcionario();
        $FuncionarioE = new Models\FuncionarioE();
        
        $FuncionarioE->fnc_id = $requestData["fnc_id"];
        
        $result = $Funcionario->consultarFuncionario($FuncionarioE);
        if ($result === false)
        {
          $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados do funcionário!"];
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

    public function incluirFuncionario()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Funcionario();
        $Entity = new Models\FuncionarioE();

        array_walk_recursive($requestData, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
        });

        if (empty($requestData["fnc_nome"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O nome do funcionário não pode estar em branco.";
        }
        else if (!is_numeric($requestData["fnc_rg"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O RG não pode estar em branco.";
        }
        else if (!is_numeric($requestData["fnc_cpf"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O CPF não pode estar em branco.";
        }
        else if (!is_numeric($requestData["fnc_telefone"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O telefone não pode estar em branco.";
        }
        else if (empty($requestData["fnc_email"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O email não pode estar em branco.";
        }
        else if (empty($requestData["fnc_endereco"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O endereço não pode estar em branco.";
        }
        else if (empty($requestData["fnc_cidade"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "A cidade não pode estar em branco.";
        }
        else if (empty($requestData["fnc_funcao"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "A função do funcionário não pode estar em branco.";
        }
        else if (empty($requestData["fnc_salario"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O salario não pode estar em branco.";
        }
        else if (is_numeric($requestData["fnc_salario"]) == false)
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O salario inserido é inválido.";
        }
        else if (empty($requestData["fnc_usuario"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O usuário não pode estar em branco.";
        }
        else
        {
          $Entity->fnc_nome = $requestData["fnc_nome"];
          $Entity->fnc_rg = $requestData["fnc_rg"];
          $Entity->fnc_cpf = $requestData["fnc_cpf"];
          $Entity->fnc_telefone = $requestData["fnc_telefone"];
          $Entity->fnc_email = $requestData["fnc_email"];
          $Entity->fnc_endereco = $requestData["fnc_endereco"];
          $Entity->fnc_cep = $requestData["fnc_cep"];
          $Entity->fnc_cidade = $requestData["fnc_cidade"];
          $Entity->fnc_funcao = $requestData["fnc_funcao"];
          $Entity->fnc_salario = $requestData["fnc_salario"];
          $Entity->fnc_usuario = $requestData["fnc_usuario"];

          $resp = $Model->cadastrarFuncionario($Entity);
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

    public function excluirFuncionario()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Funcionario();
        $Entity = new Models\FuncionarioE();

        $Entity->fnc_id = $requestData["fnc_id"];

        $resp = $Model->excluirFuncionario($Entity);
        if ($resp === true)
        {
          $jsondata['success'] = true;
          $jsondata['message'] = "Operação realizada com sucesso.";
        }
        else
        {
          $jsondata['success'] = false;
          $jsondata['message'] = "Ocorreu um erro ao excluir o funcionário selecionado.";
        }
        echo json_encode($jsondata);
      }
      catch (Exception $exception)
      {
        throw new Exception($exception, 500);
      }
    }

    public function alterarFuncionario()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Funcionario();
        $Entity = new Models\FuncionarioE();

        array_walk_recursive($requestData, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
        });

        if (empty($requestData["fnc_id"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "Ocorreu um erro ao identificar o funcionário a ser alterado.";
        }
        else if (empty($requestData["fnc_nome"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O nome do funcionário não pode estar em branco.";
        }
        else if (!is_numeric($requestData["fnc_rg"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O RG não pode estar em branco.";
        }
        else if (!is_numeric($requestData["fnc_cpf"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O CPF não pode estar em branco.";
        }
        else if (!is_numeric($requestData["fnc_telefone"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O telefone não pode estar em branco.";
        }
        else if (empty($requestData["fnc_email"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O email não pode estar em branco.";
        }
        else if (empty($requestData["fnc_endereco"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O endereço não pode estar em branco.";
        }
        else if (empty($requestData["fnc_cidade"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O cidade não pode estar em branco.";
        }
        else if (empty($requestData["fnc_funcao"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O função do funcionário não pode estar em branco.";
        }
        else if (empty($requestData["fnc_salario"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O salario não pode estar em branco.";
        }
        else if (is_numeric($requestData["fnc_salario"]) == false)
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O salario não pode estar em branco.";
        }
        else if (empty($requestData["fnc_usuario"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O usuário não pode estar em branco.";
        }
        else
        {
          $Entity->fnc_id = $requestData["fnc_id"];
          $Entity->fnc_nome = $requestData["fnc_nome"];
          $Entity->fnc_rg = $requestData["fnc_rg"];
          $Entity->fnc_cpf = $requestData["fnc_cpf"];
          $Entity->fnc_telefone = $requestData["fnc_telefone"];
          $Entity->fnc_email = $requestData["fnc_email"];
          $Entity->fnc_endereco = $requestData["fnc_endereco"];
          $Entity->fnc_cep = $requestData["fnc_cep"];
          $Entity->fnc_cidade = $requestData["fnc_cidade"];
          $Entity->fnc_funcao = $requestData["fnc_funcao"];
          $Entity->fnc_salario = str_replace(",", ".", $requestData["fnc_salario"]);
          $Entity->fnc_usuario = $requestData["fnc_usuario"];

          $resp = $Model->alterarFuncionario($Entity);
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

    public function consultarFuncionarios()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Funcionario();

        $columns = array(
          0 => 'fnc_id',
          1 => 'fnc_nome',
          2 => 'fnc_rg',
          3 => 'fnc_cpf',
          4 => 'fnc_telefone',
          5 => 'fnc_email',
          6 => 'fnc_endereco',
          7 => 'fnc_cep',
          8 => 'fnc_cidade',
          9 => 'fnc_funcao',
          10 => 'fnc_salario',
          11 => 'fnc_usuario'
        );

        $draw = $requestData['draw'];
        $search = $requestData['search']['value'];
        $order = $columns[$requestData['order'][0]['column']];
        $dir = $requestData['order'][0]['dir'];
        $start = (int) $requestData['start'];
        $length = (int) $requestData['length'];

        $totalData = count($Model->consultarFuncionarios());
        $lSCadastro = $Model->consultarFuncionarioSearch($search, $order, $dir, $start, $length);

        if ($totalData > 0)
        {
          array_walk_recursive($lSCadastro, function(&$value)
          {
            $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
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

    public function gerarRelFunc()
    {
      try
      {
        $requestData = $_REQUEST;
        $Model = new Models\Funcionario();
      }
      catch (Exception $exception)
      {
        throw new Exception($exception, 500);
      }
    }
  }