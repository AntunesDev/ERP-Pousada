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

}