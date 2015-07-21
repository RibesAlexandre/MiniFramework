<?php
namespace Core\Factories;

use \App\App;
use \Core\Config;

/**
 * Class DatabaseFactory
 *
 * @package Core\Factories
 */
class DatabaseFactory
{
	/**
	 * Initialise la base de donnée selon le driver choisi
	 *
	 * @return mixed
	 */
	public static function initDB()
	{
		$cfg = Config::getInstance('database');
		$database = '\\Core\\Database\\' . $cfg->get('driver') . 'Database';
		return new $database($cfg->get('db_name'), $cfg->get('db_user'), $cfg->get('db_pass'), $cfg->get('db_host'));
	}

	/**
	 * Retourne l'instance de la base de donnée
	 *
	 * @return mixed
	 */
	public static function db()
	{
		return App::getInstance()->getDB();
	}
}