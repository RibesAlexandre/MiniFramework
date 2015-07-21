<?php
namespace Core\Auth;
/**
 * Auth.php
 */
use \Core\Session;
use \Core\Auth\AuthDatabase;

class Auth
{
	private $authDB;
	private $isLogged = false;

	public function __construct()
	{
		if( Session::keyExists('logged') && Session::get('logged') )
		{
			$this->isLogged = true;
		}
		$this->authDB = new AuthDatabase();
	}

	public function attempt($email, $password)
	{
		if( $this->isLogged() )
		{
			App::getInstance()->response()->redirect('index.php');
		}
	}

	public function logout()
	{
		if( $this->isLogged )
		{
			Session::destroy();
			App::getInstance()->response()->redirect('index.php');
		}
	}

	public function register($email, $password)
	{
		if( $this->isLogged() )
		{
			App::getInstance()->response()->redirect('index.php');
		}
	}
}