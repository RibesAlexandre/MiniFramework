<?php
namespace Core\Factories;

use \App\Exceptions\RouterException;

/**
 * Class ControllerFactory
 *
 * @package Core\Factories
 */
class ControllerFactory
{
	/**
	 * Retourne le controller
	 *
	 * @param $controller
	 * @return mixed
	 * @throws \App\Exceptions\RouterException
	 */
	public static function createController($controller)
	{
		$controller = str_replace('/', '\\', $controller);
		$control = "App\\Controllers\\" . $controller . "Controller";

		//	On vérifie que le controller existe
		if( !class_exists($control) )
		{
			throw new RouterException('Le controlleur ' . $control . ' n\'existe pas.');
		}
		return new $control();
	}

	/**
	 * Vérifie si la méthode du controller existe
	 *
	 * @param $controller
	 * @param $method
	 * @throws \App\Exceptions\RouterException
	 */
	public static function createMethod($controller, $method)
	{
		//	On vérifie que la méthode existe
		if( !method_exists($controller, $method) )
		{
			throw new RouterException('La méthode ' . $method . 'n\'existe pas.');
		}
		return $method;
	}
}