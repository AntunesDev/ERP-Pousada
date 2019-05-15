<?php
namespace Controllers;

use Core, Models;

class HomeController extends Core\Controller {

    public function __construct() {
        parent::__construct();
        $this->isLoggedIn();
    }

    public function index() {

        $data = [];

        $data["message"] = "Hello MVC World";

        $this->loadTemplate('Home/home', $data);
    }
}
