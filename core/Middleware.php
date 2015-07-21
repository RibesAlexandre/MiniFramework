<?php
namespace Core;

/**
 * Class Middleware
 *
 * @package Core
 */
abstract class Middleware
{
	private $middlewares;

	public function __construct()
	{
		$cfg = Config::getInstance('middlewares');
		$this->middlewares = $cfg->getSettings();
	}

	abstract public function next();

}