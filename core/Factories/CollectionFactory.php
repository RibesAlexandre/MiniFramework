<?php
namespace Core\Factories;

/**
 * Class CollectionFactory
 *
 * @package Core\Factories
 */
class CollectionFactory
{
	public static function loadCollection($collection)
	{
		$className = '\\App\\Collections\\' . ucfirst($collection) . 'Collection';
		$modelName = ucfirst($collection) . 'Model';
		return new $className($modelName);
	}
}