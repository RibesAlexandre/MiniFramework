<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);

function dd($array = array())
{
	print '<pre>';
	print_r($array);
	print '</pre>';
}

//	On lance notre application
require_once(ROOT . 'App/App.php');
$app = App\App::getInstance();
$app->run();

//	Définition des routes
$app->route()->get('/', 'Company@index');
$app->route()->get('/admin', 'Admin/Dashboard@index');
$app->route()->crud('/companies', 'Company');
$app->route()->run();