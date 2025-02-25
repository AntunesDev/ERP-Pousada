<?php
namespace Controllers;

use Core, Models, Exception;
use Core\Config;

class LoginController extends Core\Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->isLoggedOut();
    $data = [];
    $this->loadTemplateLogin('Login/login', $data);
  }

  public function login()
  {
    $data = [];
    $U = new Models\Usuario();
    $E = new Models\UsuarioE();

    if (isset($_POST) && !empty($_POST))
    {
      if (!empty($_POST["login-user"]) && !empty($_POST["login-password"]))
      {
        $E->usr_name = trim($_POST["login-user"]);
        $E->usr_senha = trim($_POST["login-password"]);
        $usuario = $U->verificarUsuario($E);
      }
      else
      {
        $this->loadTemplateLogin('Login/login', $data);
      }
    }

    if ($usuario != false)
    {
      $validPassword = password_verify($E->usr_senha, $usuario->usr_senha);
      
      if ($validPassword)
      {
        $_SESSION[$this->Config::SESSION_NAME] = 
        ["user" =>
          ["data" => 
            [
              "id"        => $usuario->usr_id,
              "usuario"       => $usuario->usr_name,
              "grupo_acessos" => $usuario->usr_grupo
            ]
          ]
        ];     

        die(header('Location: '.BASE_URL));
      }
      else
      {
        $data = ["erros" => ["erroUsuario" => "Senha incorreta."]];
      }
    }
    else
    {
      $data = ["erros" => ["erroUsuario" => "Usuario não existe."]];
    }
    
    $this->loadTemplateLogin('Login/login', $data);
  }

  public function logout()
  {
    unset($_SESSION[$this->Config::SESSION_NAME]);
    die(header('Location: '.BASE_URL));
  }

  public function extendSession()
  {
    $this->renewSession(); 
  }

}
