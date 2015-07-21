<?php
namespace App\Controllers;

/**
 * Class HomeController
 *
 * @package App\Controllers
 */
class HomeController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}




	public function hello()
	{
		$this->data += [
			'variable'	=>	'test',
		];

		return $this->layout()->render('home', $this->data);
	}

	public function show($id)
	{
		echo 'Je suis l\'id n°' . $id;
	}

}