<?php
namespace App\Middlewares;

use \Core\Auth\Auth;
use \Core\Middleware;

/**
 * Class RedirectIfAuthentifiedMiddleware
 *
 * @package App\Middlewares
 */
class RedirectIfAuthentifiedMiddleware extends Middleware
{
	protected $redirect = '/';

	public function __construct()
	{
		parent::__construct();
	}

	public function next()
	{
		if( !Auth::check() )
		{
			return App::getInstance()->response()->redirect($this->redirect);
		}
		return true;
	}
}