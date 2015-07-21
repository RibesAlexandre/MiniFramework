<?php
namespace Core;

use App\Exceptions\LayoutException;

/**
 * Class Layout
 *
 * @package Core
 */
class Layout
{
	private $path;
	private static $_instance;

	public function __construct($path = 'App/Views')
	{
		$this->path = $path;
	}

	public static function getInstance()
	{
		if( is_null(self::$_instance) )
		{
			self::$_instance = new Layout();
		}
		return self::$_instance;
	}

	private function getFile($file, $data = [])
	{
		if( is_file(ROOT . $this->path . '/' . $file . '.tpl.php') )
		{
			ob_start();
			extract($data);
			require_once(ROOT . $this->path . '/' . $file . '.tpl.php');
			$content = ob_get_contents();
			ob_end_clean();

			return $content;
		}
		throw new LayoutException('Le fichier de template ' . $file . ' n\'existe pas');
	}

	public function render($file, $data)
	{
		$title = $data['title'];
		$content = $this->getFile($file, $data);
		require_once(ROOT . $this->path . '/layouts/layout.tpl.php');
	}
}