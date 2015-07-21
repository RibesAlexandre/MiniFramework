<?php
namespace Core\Auth;
/**
 * AuthDatabase.php
 */
use \Core\Session;
use \Core\Database\Database;
use \Core\Factories\ModelFactory;

class AuthDatabase extends Auth
{
	private $db;
	private $model;

	public function __construct(Database $db)
	{
		$this->db = $db;
		$this->model = ModelFactory::loadModel('users');
	}

	/**
	 * Récupère l'id de l'utilisateur
	 *
	 * @return string|null
	 */
	public function getUserId()
	{
		return Session::get('auth');
	}

	/**
	 * Crée une session utilisateur si les logins correspodent
	 *
	 * @param $email
	 * @param $password
	 * @return bool
	 */
	public function login($email, $password)
	{
		$user = $this->db->prepare(
			'SELECT * FROM ' . $this->model->table . '
			WHERE email = ? AND password = ?'
		, [$email, $password], true);

		if( $user )
		{
			Session::set('auth', $user->id);
			return true;
		}
		return false;
	}

	/**
	 * Détermine si l'utilisateur est connecté
	 *
	 * @return bool
	 */
	public function logged()
	{
		return Session::keyExists('auth');
	}
}