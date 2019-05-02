<?php
namespace Core;

use Core\Helpers as Helpers;

class Acl {

  protected $Helper;
  protected $Config;

  public function __construct(){
    $this->Helper = new Helpers\Helper;
    $this->Config = new Config;
  }

  public function isLoggedIn() {
		if(empty($_SESSION[Config::SESSION_NAME])){
			die(header('Location: '.BASE_URL."login"));
		}
	}

	public function isLoggedOut() {
		if(!empty($_SESSION[Config::SESSION_NAME])){
			die(header('Location: '.BASE_URL."home"));
		}
	}

	public function hashPassword($password) {
    $options = ['cost' => 11];
    $pass = password_hash($password, PASSWORD_BCRYPT, $options);
    return $pass;
  }

  public function verifyPassword($password, $hash){
    if (password_verify($password, $hash)) {
        return true;
    } else {
        return false;
    }
  }

  public function hasPermission($className) {
		$permission = $this->Helper->arraySearch($className, $_SESSION[Config::SESSION_NAME]);

    if ($permission != 'url') {
      die(header('Location: '.BASE_PATH."home"));
    }

    return true;
  }

  public function renewSession() {
    if (isset($_SESSION[Config::SESSION_NAME]))
      $_SESSION[Config::SESSION_NAME] = $_SESSION[Config::SESSION_NAME];
  }
}
