<?php
  namespace Controllers;

  use Core, Models, Exception;
  use Core\Config;

  class ProdutosController extends Core\Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->isLoggedIn();
    }

    public function index()
    {
      $data = [];
      $this->loadTemplate('Produto/cadastro', $data);
    }

    public function buscarProduto()
    {
      try
      {
        $requestData = $_REQUEST;

        $Produto = new Models\Produto();
        $ProdutoE = new Models\ProdutoE();

        $ProdutoE->prd_id = $requestData["prd_id"];
        $result = $Produto->buscarProduto($ProdutoE);

        if ($result === false)
        {
          $json_data = ["success" => false, "message" => "Ocorreu um erro ao buscar os dados do produto!"];
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

    public function incluirProduto()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Produto();
        $Entity = new Models\ProdutoE();

        array_walk_recursive($requestData, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
        });

        if (empty($requestData["prd_descricao"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O produto não pode estar em branco.";
        }
        else if (empty($requestData["prd_valor"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O valor não pode estar em branco.";
        }
        else if (is_numeric($requestData["prd_valor"]) == false)
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "Um valor válido deve ser preenchido.";
        }
        else
        {
          $Entity->prd_descricao = $requestData["prd_descricao"];
          $Entity->prd_valor = $requestData["prd_valor"];

          $resp = $Model->cadastrarProduto($Entity);
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

    public function excluirProduto()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Produto();
        $Entity = new Models\ProdutoE();

        $Entity->prd_id = $requestData["prd_id"];

        $resp = $Model->excluirProduto($Entity);
        if ($resp === true)
        {
          $jsondata['success'] = true;
          $jsondata['message'] = "Operação realizada com sucesso.";
        }
        else
        {
          $jsondata['success'] = false;
          $jsondata['message'] = "Ocorreu um erro ao excluir o produto selecionado.";
        }
        echo json_encode($jsondata);
      }
      catch (Exception $exception)
      {
        throw new Exception($exception, 500);
      }
    }

    public function alterarProduto()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Produto();
        $Entity = new Models\ProdutoE();

        array_walk_recursive($requestData, function(&$value)
        {
          $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], $value));
        });

        if (empty($requestData["prd_id"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "Ocorreu um erro ao identificar o produto a ser alterado.";
        }
        else if (empty($requestData["prd_descricao"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "O produto não pode estar em branco.";
        }
        else if (empty($requestData["prd_valor"]))
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "Um valor deve ser preenchido.";
        }
        else if (is_numeric($requestData["prd_valor"]) == false)
        {
          $jsondata["success"] = false;
          $jsondata["message"] = "Um valor válido deve ser preenchido.";
        }
        else
        {
          $Entity->prd_id = $requestData["prd_id"];
          $Entity->prd_descricao = $requestData["prd_descricao"];
          $Entity->prd_valor = str_replace(",", ".", $requestData["prd_valor"]);

          $resp = $Model->alterarProduto($Entity);
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

    public function consultarProdutos()
    {
      try
      {
        $requestData = $_REQUEST;

        $Model = new Models\Produto();

        $columns = array(
          0 => 'prd_id',
          1 => 'prd_descricao',
          2 => 'prd_valor'
        );

        $draw = $requestData['draw'];
        $search = $requestData['search']['value'];
        $order = $columns[$requestData['order'][0]['column']];
        $dir = $requestData['order'][0]['dir'];
        $start = (int) $requestData['start'];
        $length = (int) $requestData['length'];

        $totalData = count($Model->consultarProdutos());
        $lSCadastro = $Model->consultarProdutosSearch($search, $order, $dir, $start, $length);

        if ($totalData > 0)
        {
          array_walk_recursive($lSCadastro, function(&$value, $key)
          {
            if ($key == "prd_valor")
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

    public function gerarRelProd()
    {
      try
      {
        $requestData = $_REQUEST;
        $Model = new Models\Produto();
      }
      catch (Exception $exception)
      {
        throw new Exception($exception, 500);
      }
    }

    public function listarProdutos()
    {
      try
      {
        $Model = new Models\Produto();
  
        $totalData = $Model->consultarProdutos();
        
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