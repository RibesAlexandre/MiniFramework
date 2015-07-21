<?php
namespace Core\Http;

/**
 * Class Request
 *
 * @package Core\Http
 */
class Request
{
	private $routes;
	/**
	 * Retourne la valeur d'un cookie en fonction de sa clée
	 *
	 * @param $key
	 * @return null|string
	 */
	public function getCookie($key)
	{
		return isset($_COOKIE[$key]) ? htmlspecialchars($_COOKIE[$key]) : null;
	}

	/**
	 * Détermine si un cookie existe
	 *
	 * @param $key
	 * @return bool
	 */
	public function cookieExists($key)
	{
		return isset($_COOKIE[$key]);
	}

	/**
	 * Récupère la valeur d'un paramètre passé en URL
	 *
	 * @param $url
	 * @return null|string
	 */
	public function getData($url)
	{
		return isset($_GET[$url]) ? htmlspecialchars($_GET['url']) : null;
	}

	/**
	 * Détermine si le paramètre URL existe
	 *
	 * @param $url
	 * @return bool
	 */
	public function getExists($url)
	{
		return isset($_GET[$url]);
	}

	/**
	 * Récupère la valeur d'une clé passée en $_POST
	 *
	 * @param $key
	 * @return null|string
	 */
	public function getPost($key)
	{
		return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
	}

	/**
	 * Détermine si une clé passée en $_POST existe
	 *
	 * @param $key
	 * @return bool
	 */
	public function postExists($key)
	{
		return isset($_POST[$key]);
	}

	/**
	 * Récupère la méthode
	 *
	 * @return mixed
	 */
	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Récupère l'url courante
	 *
	 * @return mixed
	 */
	public function getUri()
	{
		return $_SERVER['REQUEST_URI'];
	}

	public function getRoutes($file = 'routes')
	{
		$this->routes = require_once(ROOT . 'App/Config/' . $file . '.php');
		return $this->routes;
	}
}