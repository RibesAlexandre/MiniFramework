<?php
namespace App\Models;

use \App\Models\Model;

/**
 * Class UserModel
 *
 * @package App\Models
 */
class UserModel extends Model
{
	protected $table = 'users';

	protected $fields = [
		'id'					=>	0,
		'email'				=>	'',
		'password'			=>	'',
		'auth'				=>	0,
		'create_date'		=>	'',
		'update_date'		=>	'',
		'active'				=>	0,
	];
}