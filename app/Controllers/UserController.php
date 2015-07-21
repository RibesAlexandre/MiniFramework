<?php
namespace App\Controllers;

use \Core\Controller;

/**
 * Class UserController
 *
 * @package App\Controllers
 */
class UserController extends PublicController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModed('user');
	}

	public function index()
	{

	}
}