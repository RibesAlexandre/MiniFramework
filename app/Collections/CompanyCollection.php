<?php
namespace App\Collections;

use \Core\Tables\Collection;

/**
 * Class CompanyCollection
 *
 * @package App\Collections
 */
class CompanyCollection extends Collection
{
	protected $collection = 'companies';

	protected $hidden = [];

	public function __construct()
	{
		parent::__construct();
	}
}