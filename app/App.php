<?php
namespace App;

use \Core\Config;
use \Core\Http\Request;
use \Core\Http\Response;
use \Core\Router\Router;
use \Core\Factories\DatabaseFactory;

/**
 * Class App
 *
 * @package App
 */
class App
{
	public static $title = 'GestForm';
	public static $config;

	private $_db_instance;
	private static $_instance;
	private static $_router_instance;

	private static $request;
	private static $response;

	/**
	 * Retourne l'instanciation
	 *
	 * @return \App
	 */
	public static function getInstance()
	{
		if( is_null(self::$_instance) )
		{
			self::$_instance = new App();
		}
		return self::$_instance;
	}

	/**
	 * Lance l'application et charge les autoloaders
	 */
	public static function run()
	{
		session_start();
		require_once(ROOT . 'App/Autoloader.php');
		\App\Autoloader::register();
		require_once(ROOT . 'Core/Autoloader.php');
		\Core\Autoloader::register();

		self::$config = new \Core\Config('config');
		self::$title = self::config()->get('site_name');

		self::$request = new Request();
		self::$response = new Response();
	}

	/**
	 * Raccourci pour les routes
	 *
	 * @return \Core\Router\Router
	 */
	public static function route()
	{
		if( is_null(self::$_router_instance) )
		{
			self::$_router_instance = new Router(self::request()->getData('url'));
		}
		return self::$_router_instance;
	}

	/**
	* Retourne une instance de la base de donnée
	*
	* @return \App\Database
	*/
	public function getDB()
	{
		if( is_null($this->_db_instance) )
		{
			$this->_db_instance = DatabaseFactory::initDB();
		}
		return $this->_db_instance;
	}

	/**
	 * Retourne une instance de la classe Request
	 *
	 * @return \Core\Request
	 */
	public static function request()
	{
		return self::$request;
	}

	/**
	 * Retourne une instance de la classe Response
	 *
	 * @return \Core\Response
	 */
	public static function response()
	{
		return self::$response;
	}

	/**
	 * @return mixed
	 */
	public static function config()
	{
		return self::$config;
	}

	/**
	* Retourne le titre de la page
	*
	* @return string
	*/
	public static function getTitle()
	{
		return self::$title;
	}

	/**
	* Attribue un titre à la page
	*
	* @param $title
	*/
	public static function setTitle($title)
	{
		self::$title = $title;
	}
}