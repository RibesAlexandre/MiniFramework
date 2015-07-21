<?php
namespace Core;

/**
 * Class Autoloader
 *
 * @package App
 */
class Autoloader
{
    /**
     *  Enregistre notre autoloader
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Inclut le fichier correspondant à notre classe
     * @param $class string : le nom de la classe à charger
     */
    public static function autoload($class)
    {
        if( strpos($class, __NAMESPACE__ . '\\') === 0 )
        {
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);

            require __DIR__ . '/' . $class . '.php';
        }
    }
}