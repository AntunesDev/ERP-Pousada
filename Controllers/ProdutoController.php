<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class ProdutoController extends Core\Controller
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

  public function consultarProduto()
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
        $json_data = ["success" => true, "result" => $result];
      }

      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

  public function cadastrarProduto()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Produto();
      $Entity = new Models\ProdutoE();

      array_walk_recursive($requestData, function(&$value)
      {
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], utf8_encode($value)));
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
      else if (is_numeric($requestData["prd_valor"] == false))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um valor deve ser preenchido.";
      }
      else
      {
        $Entity->usr_name = $requestData["prd_descricao"];
        $Entity->usr_grupo = $requestData["prd_valor"];

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
        $jsondata['message'] = "Ocorreu um erro ao excluir o usuário selecionado.";
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
        $value = $this->Helper->removeAccents(str_replace(['"', ","], ['','.'], utf8_encode($value)));
      });

      if (empty($requestData["prd_id"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Ocorreu um erro ao identificar o produto a ser alterado.";
      }
      else if (empty($requestData["usr_descricao"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "O produto não pode estar em branco.";
      }
      else if (empty($requestData["prd_valor"]))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um valor deve ser preenchido.";
      }
      else if (is_numeric($requestData["prd_valor"] == false))
      {
        $jsondata["success"] = false;
        $jsondata["message"] = "Um valor deve ser preenchido.";
      }
      else
      {
        $Entity->prd_id = $requestData["prd_id"];
        $Entity->prd_descricao = $requestData["prd_descricao"];
        $Entity->prd_valor = $requestData["prd_valor"];

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

  public function gerarRelProd()
  {
    try
    {
      $requestData = $_REQUEST;

      $Model = new Models\Produto();

      $totalData = count($Model->gerarRelProd());
      echo json_encode($json_data);
    }
    catch (Exception $exception)
    {
      throw new Exception($exception, 500);
    }
  }

}