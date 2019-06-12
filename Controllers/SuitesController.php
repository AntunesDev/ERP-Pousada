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

}