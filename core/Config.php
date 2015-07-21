<?php
namespace Core;

/**
 * Class Config
 *
 * @package Core
 */
class Config
{
	private $settings = [];
	private static $_instance;

	/**
	 * Instanciation
	 *
	 * @param $file
	 * @return \Core\Config
	 */
	public function getInstance($file)
	{
		if( is_null(self::$_instance) )
		{
			self::$_instance = new Config($file);
		}
		return self::$_instance;
	}

	/**
	 * Construteur
	 * Récupère le fichier de configuration passé en paramètre
	 *
	 * @param $file
	 */
	public function __construct($file)
	{
		$this->settings = require(dirname(__DIR__) . '/App/Config/' . $file . '.php');
	}

	/**
	 * Retourne une clé de configuration
	 *
	 * @param $key
	 * @return string|null
	 */
	public function get($key)
	{
		if( isset($this->settings[$key]) )
		{
			return $this->settings[$key];
		}
		return null;
	}

	/**
	 * Retourne le tableau contenant les paramètres
	 *
	 * @return array|mixed
	 */
	public function getSettings()
	{
		return $this->settings;
	}
}
