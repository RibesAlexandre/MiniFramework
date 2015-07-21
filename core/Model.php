<?php
namespace Core;

use \Core\Database\Database;

/**
 * Class Model
 *
 * @package Core
 */
class Model
{
	protected $db;
	protected $_table;
	protected $_fields = [];

	/**
	 * Constructeur
	 * Récupère l'instanciation de la base de donnée pour effectuer
	 * toutes les requêtes
	 *
	 * @param \Core\Database\Database $db
	 */
	public function __construct(Database $db)
	{
		$this->db = $db;
		if( is_null($this->_table) )
		{
			$model = explode('\\', get_class($this));
			$className = end($model);
			$this->_table = strtolower(str_replace('Model', '', $className)) . 's';
		}
	}

	/**
	 * Retourne un résultat unique en fonction de son id et remplit les
	 * attributs en conséquence
	 *
	 * @param $id
	 * @return mixed
	 */
	public function load($id)
	{
		$data = $this->query('SELECT * FROM ' . $this->_table . ' WHERE id = ?', [$id], true);
		if( !$data )
		{
			return false;
		}
		foreach($data as $key => $value)
		{
			if( array_key_exists($key, $this->_fields) )
			{
				$this->_fields[$key] = $value;
			}
		}
		return $this->_fields;
	}

	/**
	 * Retourne la valeur d'une clé du tableau
	 *
	 * @param $key
	 * @return string
	 */
	public function getData($key)
	{
		if( isset($this->_fields[$key]) )
		{
			return $this->_fields[$key];
		}
		return '';
	}

	/**
	 * Renseigne les champs
	 *
	 * @param $data
	 */
	public function store($data)
	{
		foreach( $this->_fields as $field )
		{
			$this->_fields[$field] = $data[$field];
		}
	}

	/**
	 * Sauvegarde les champs selon s'il s'agit d'une nouvelle entrée
	 *
	 * @return mixed
	 */
	public function save()
	{
		if( is_null($this->_fields['id']) || empty($this->_fields['id']) || $this->_fields['id'] == 0 )
		{
			return $this->insert($this->_fields);
		}

		return $this->update($this->_fields, $this->_fields['id']);
	}

	/**
	 * Insère les données dans la table à partir d'un tableau associatif
	 *
	 * @param $data
	 * @return mixed
	 */
	public function insert($data)
	{
		$sql = 'INSERT INTO ' . $this->_table . ' SET ';

		$count = 0;
		$attributes = [];
		foreach( $data as $key => $value )
		{
			$sql .= $key . ' = :' . $key;
			if( $count < (count($data) - 1) )
			{
				$sql .= ', ';
			}
			$attributes = array_merge($attributes, [
				':' . $key => $value,
			]);
			$count++;
		}

		return $this->db->execute($sql, $attributes);
	}

	/**
	 * Met à jour les données d'une ligne grâce à un tableau associatif
	 * et l'id passée en paramètre
	 *
	 * @param $data
	 * @param $id
	 * @return mixed
	 */
	public function update($data, $id)
	{
		$sql = 'UPDATE ' . $this->_table . ' SET ';

		$count = 0;
		$attributes = [];
		foreach( $data as $key => $value )
		{
			$sql .= $key . ' = :' . $key;
			if( $count < (count($data) - 1) )
			{
				$sql .= ', ';
			}
			$attributes = array_merge($attributes, [
				':' . $key => $value,
			]);
			$count++;
		}
		$sql .= ' WHERE id = :id';
		$attributes = array_merge($attributes, [
			':id'	=>	intval($id),
		]);

		return $this->db->execute($sql, $attributes);
	}

	/**
	 * Suppression d'une ligne de la base de donnée
	 *
	 * @return mixed
	 */
	public function delete()
	{
		return $this->db->execute('DELETE FROM ' . $this->_table . ' WHERE id = ?', [$this->fields['id']]);
	}

	/**
	 * Exécute une requête préparée ou non en fonction des paramètres
	 *
	 * @param            $statement
	 * @param null       $attributes
	 * @param bool|FALSE $one
	 * @return mixed
	 */
	public function query($statement, $attributes = null, $one = false)
	{
		if( $attributes )
		{
			return $this->db->prepare($statement, $attributes, $one);
		}
		else
		{
			return $this->db->query($statement, $one);
		}
	}
}