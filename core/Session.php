<?php
namespace Core;

/**
 * Class Session
 *
 * @package Core
 */
class Session
{
	public function __construct()
	{
		return session_start();
	}

	/**
	 * Définit une valeur à une clé de session
	 *
	 * @param $key
	 * @param $value
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Récupère une clé de session
	 *
	 * @param $key
	 * @return null
	 */
	public static function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/**
	 * Détermine si une clé de session existe
	 *
	 * @param $key
	 * @return bool
	 */
	public static function keyExists($key)
	{
		return isset($_SESSION[$key]);
	}

	/**
	 * Supprime une clé de session
	 *
	 * @param $key
	 */
	public static function void($key)
	{
		unset($_SESSION[$key]);
	}

	/**
	 * Termine la session
	 *
	 * @return bool
	 */
	public static function destroy()
	{
		return session_destroy();
	}

	/**
	 * Crée une variable flash avec un type spécifique
	 *
	 * @param $key
	 * @param $value
	 */
	public static function setFlash($key, $value)
	{
		$_SESSION['flash']['type'] = $key;
		$_SESSION['flash']['message'] = $value;
	}

	/**
	 * Récupère une variable flash
	 *
	 * @return array()
	 */
	public static function getFlash()
	{
		$flash = extract($_SESSION['flash']);
		unset($_SESSION['flash']);
		return $flash;
	}
}