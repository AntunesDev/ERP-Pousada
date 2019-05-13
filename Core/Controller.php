<?php
namespace Core;

class Controller extends Acl {
  public function __construct() {
    parent::__construct();
  }

  public function loadView($viewName, $viewData = []) {
    extract($viewData);
    include 'views/'.$viewName.'.php';
  }

  public function loadViewInTemplate($viewName, $viewData) {
    extract($viewData);
    include 'views/'.$viewName.'.php';
  }

  public function loadTemplate($viewName, $viewData) {
    include 'views/template/template.php';
  }

  public function loadTemplateLogin($viewName, $viewData) {
		include 'views/Login/login.php';
	}
}
