<?php
namespace Core\Factories;

/**
 * Class ModelFactory
 *
 * @package Core\Factories
 */
class ModelFactory
{
	public static function loadModel($model)
	{
		$className = '\\App\\Models\\' . ucfirst($model) . 'Model';
		return new $className(DatabaseFactory::db());
	}
}