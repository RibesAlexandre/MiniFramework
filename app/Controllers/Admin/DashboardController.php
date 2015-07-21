<?php
namespace App\Controllers\Admin;

use \App\Controllers\Controller;

/**
 * Class DashboardController
 *
 * @package App\Controllers\Admin
 */
class DashboardController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function indexAction()
	{
		echo 'dashboard';
	}
}