<?php
namespace Core\Http;

/**
 * Class Response
 *
 * @package Core\Http
 */
class Response
{
	/**
	 * Définit un nouveau header
	 *
	 * @param $header
	 */
	public function setHeader($header)
	{
		header($header);
	}

	/**
	 * Etablit une redirection
	 *
	 * @param $location
	 */
	public function redirect($location)
	{
		header('Location:' . $location);
		exit;
	}

	/**
	 * Crée un nouveau cookie
	 *
	 * @param            $name
	 * @param string     $value
	 * @param int        $expire
	 * @param null       $path
	 * @param null       $domain
	 * @param bool|FALSE $secure
	 * @param bool|TRUE  $httpOnly
	 */
	public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
	{
		secookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
	}

	/**
	 * Retourne une page d'erreur avec un header spécifique
	 *
	 * @param $code
	 */
	public function abort($code)
	{
		switch( $code )
		{
			case '404':
				$this->setHeader('HTTP/1.0 404 Not Found');
				return $this->redirect(ROOT . $code);
			break;

			case '403':
				$this->setHeader('HTTP/1.O 403 Forbidden');
				return $this->redirect(ROOT . $code);

			default:
				return $this->redirect(ROOT . 'index.php');
		}
	}
}