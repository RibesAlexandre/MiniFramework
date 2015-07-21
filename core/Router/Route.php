<?php
namespace Core\Router;

use \Core\Factories\ControllerFactory;

/**
 * Class Route
 *
 * @package Core\Router
 */
class Route
{
	private $path;
	private $callable;
	private $matches;
	private $params = [];
	private $middleware;

	public function __construct($path, $callable)
	{
		$this->path = trim($path, '/');
		$this->callable = $callable;
	}

	/**
	 * Associe une condition à la route (regex)
	 *
	 * @param $param
	 * @param $regex
	 * @return $this
	 */
	public function with($param, $regex)
	{
		$this->params[$param] = str_replace('(', '(?:', $regex);
		return $this;
	}

	/**
	 * Définit un ou des middleware(s) à la route
	 *
	 * @param $middleware
	 */
	public function middleware($middleware)
	{
		if( is_array($middleware) )
		{
			foreach( $middleware as $middleware )
			{
				$this->middlewares[] = $middleware;
			}
		}
		else
		{
			$this->middleware = $middleware;
		}
	}

	/**
	 * Vérifie que la route est en adéquation avec le(s) paramètre(s)
	 *
	 * @param $url
	 * @return bool
	 */
	public function match($url)
	{
		$url = trim($url, '/');
		$path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
		$regex = "#^$path$#i";
		if( !preg_match($regex, $url, $matches) )
		{
			return false;
		}
		array_shift($matches);
		$this->matches = $matches;
		return true;
	}

	/**
	 * Applique les Regex pour le callback
	 *
	 * @param $match
	 * @return string
	 */
	private function paramMatch($match)
	{
		if( isset($this->params[$match[1]]) )
		{
			return '(' . $this->params[$match[1]] . ')';
		}
		return '([^/]+)';
	}

	/**
	 * Retourne l'action demandée
	 *
	 * @return mixed
	 * @throws \App\Exceptions\RouterException
	 */
	public function call()
	{
		if( is_string($this->callable) )
		{
			if( !empty($this->middleware) )
			{
				//	A compléter
			}

			$params = explode('@', $this->callable);
			$controller = ControllerFactory::createController($params[0]);
			$method = ControllerFactory::createMethod($controller, $params[1]);

			//	On retourne le controller avec ses paramètres
			return call_user_func_array([$controller, $method], $this->matches);
		}
		else
		{
			//	On retourne la closure
			return call_user_func_array($this->callable, $this->matches);
		}
	}

	/**
	 * Retourne l'url formatée
	 *
	 * @param $params
	 * @return mixed|string
	 */
	public function getUrl($params)
	{
		$path = $this->path;
		foreach( $params as $k => $v )
		{
			$path = str_replace(":$k", $v, $path);
		}
		return $path;
	}
}