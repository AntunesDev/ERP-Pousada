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

}