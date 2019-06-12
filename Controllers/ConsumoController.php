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
    $data = [];
    $this->loadTemplate('Consumo/index', $data);
  }

}