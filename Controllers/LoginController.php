<?php
namespace Controllers;

use Core, Models;
use Core\Config;

class LoginController extends Core\Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->isLoggedOut();
        $data = [];
        $this->loadTemplateLogin('Login/login', $data);
    }

    public function login(){
      $data = [];
      $U = new Models\Usuario();
      $E = new Models\UsuarioE();

      if (isset($_POST) && !empty($_POST)) {
        if (!empty($_POST["login-user"]) && !empty($_POST["login-password"])) {
          $E->senUsuario = addslashes(trim($_POST["login-user"]));
          $E->senSenha = addslashes(trim($this->passDecode($_POST["login-password"])));
          $usuario = $U->getUsuario($E);
        }else{
          $this->loadTemplateLogin('Login/login', $data);
        }
      }

      if ($usuario != false)
      {
        $expiration_date = new \DateTime($usuario->senValidade);
        if ($expiration_date > new \DateTime())
        {
          $_SESSION[$this->Config::SESSION_NAME] =  ["user" =>
              ["data" => [
                "nome" 			        => $usuario->senNome,
                "usuario"           => $usuario->senUsuario
              ]
            ]
          ];        

          die(header('Location: '.BASE_URL));
        }
        else
        {
          $data = ["erros" => ["erroUsuario" => "Usuario com senha expirada"]];
        }
      }
      else
      {
        $data = ["erros" => ["erroUsuario" => "Usuario não existe ou Senha errada"]];
      }
      
      $this->loadTemplateLogin('Login/login', $data);
    }

    private function passDecode($senha)
    {
      $crypto = [];
      $senhasBalcao = array('$' => '0','&' => '1','#' => '2','@' => '3','A' => '4','5' => '5','X' => '6','K' => '7','N' => '8','9' => '9');
  		$senha = str_split($senha);

  		foreach($senha as $k => $v){
  			$chave = array_search($v, $senhasBalcao);
  			if (!empty($chave)) {
  				$crypto[] = $chave;
  			}
      }
      
      if (count($crypto) > 0) {
        $senha = implode('',$crypto);
        return $senha;
      }else{
        return "";
      }
    }   

    public function logout(){
      unset($_SESSION[$this->Config::SESSION_NAME]);
      die(header('Location: '.BASE_URL));
    }

    public function extendSession()
    {
      $this->renewSession(); 
    }
}
