<?php
namespace Core;

use \Core\Factories\ModelFactory;

/**
 * Class Controller
 *
 * @package App\Controllers
 */
class Controller
{
	protected $title;
	protected $model;

	public function __construct()
	{
		if( empty($this->title) || is_null($this->title) )
		{
			$methods = get_class_methods(get_called_class());
			$this->title = ucfirst($methods[1]);
		}
	}

	/**
	 * @return \Core\Layout
	 */
	protected function layout()
	{
		return Layout::getInstance();
	}

	/**
	 * Retourne le modèle du controller
	 *
	 * @param $modelName
	 */
	protected function loadModed($modelName)
	{
		$this->$modelName = ModelFactory::loadModel(ucfirst($modelName));
	}
}