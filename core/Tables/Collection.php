<?php
namespace Core\Tables;

use Core\Factories\DatabaseFactory;

/**
 * Class Collection
 *
 * @package Core
 */
class Collection
{
	//	Modèle
	protected $db;
	protected $collection;

	//	Requête
	protected $fields;
	protected $from;
	protected $join = [];
	protected $conditions = [];
	protected $orderBy;
	protected $orderFields;
	protected $limit;

	//	Tableau de résultats
	public $items = [];

	protected $hidden = [];

	public function __construct()
	{
		$this->db = DatabaseFactory::db();
	}

	/**
	 * Détermine les champs à sélectionner
	 *
	 * @param string $fields
	 * @return $this
	 */
	public function select($fields = '*')
	{
		$this->fields = $fields;
		return $this;
	}

	/**
	 * Détermine la table où récupérer les données
	 *
	 * @param $table
	 * @return $this
	 */
	public function from($table)
	{
		$this->from = $table;
		return $this;
	}

	public function join($table, $compare, $method = 'INNER')
	{
		$this->join[] = [
			'table'		=>	$table,
			'compare'	=>	$compare,
			'method'		=>	$method
		];
		return $this;
	}

	/**
	 * Condition WHERE
	 *
	 * @param $key
	 * @param $cond
	 * @param $value
	 * @return $this
	 */
	public function where($key, $cond, $value)
	{
		$this->conditions[] = [
			'key'		=>	$key,
			'cond'	=>	$cond,
			'value'	=>	$value
		];
		return $this;
	}

	/**
	 * Tri des données
	 *
	 * @param        $fields
	 * @param string $order
	 * @return $this
	 */
	public function orderBy($fields, $order = 'ASC')
	{
		$this->orderFields = $fields;
		$this->orderBy = $order;
		return $this;
	}

	/**
	 * Allias par rapport à la date
	 *
	 * @return $this
	 */
	public function newest()
	{
		$this->orderBy('create_date', 'DESC');
		return $this;
	}

	/**
	 * Allias par rapport à la date
	 *
	 * @return $this
	 */
	public function latest()
	{
		$this->orderBy('create_date', 'ASC');
		return $this;
	}

	/**
	 * Limite d'affichage
	 *
	 * @param      $begin
	 * @param null $end
	 * @return $this
	 */
	public function limit($begin, $end = null)
	{
		if( is_null($end) )
		{
			$this->limit = $begin;
		}
		else
		{
			$this->limit = $begin . ', ' . $end;
		}
		return $this;
	}

	/**
	 * Exécute le requête
	 * Si l'id est fournie ne retourne qu'un seul résultat
	 *
	 * @param null $id
	 * @return array
	 */
	public function get($id = null)
	{
		if( !is_null($id) )
		{
			$this->conditions[] = 'id = ' . intval($id);
		}

		//	On onitialise la requête
		$sql = 'SELECT ' . $this->fields . ' FROM ' . $this->from;

		if( $this->check($this->join) )
		{
			foreach( $this->join as $join )
			{
				$sql .= ' ' . $join['method'] . ' JOIN ' . $join['table'];
				$sql .= ' ON ' . $join['compare'];
			}
		}

		//	On vérifie s'il y a des conditions
		if( $this->check($this->conditions) )
		{
			$count = 0;
			$attributes = [];
			$sql .= ' WHERE ';

			//	On parcourt les conditons pour formater la requête
			foreach( $this->conditions as $q )
			{
				$sql .= $q['key'] . ' ' . $q['cond'] . ' ' . ':' . $q['key'];
				if( $count < (count($this->conditions) - 1) )
				{
					$sql .= ' AND ';
				}

				//	On définit des attributs pour la requête préparée
				$attributes = array_merge($attributes, [
					':' . $q['key'] => $q['value'],
				]);
				$count++;
			}
		}

		//	On vérifie les ordres de tri
		if( $this->check($this->orderBy) && $this->check($this->orderFields) )
		{
			$sql .= ' ORDER BY ' . $this->orderFields . ' ' . $this->orderBy;
		}

		//	On vérifie si une limite est renseignée
		if( $this->check($this->limit) )
		{
			$sql .= ' LIMIT ' . $this->limit;
		}

		//	Selon le cas on fait une requête préparée
		if( $this->check($this->conditions) )
		{
			 return $this->db->prepare($sql, $attributes);
		}
		return $this->db->query($sql);
	}

	/**
	 * Retourne tous les items
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->select('*')->from($this->collection)->get();
	}

	/**
	 * Permet de checker
	 *
	 * @param $condition
	 * @return bool
	 */
	private function check($condition)
	{
		return (isset($condition) && !empty($condition) );
	}

	/**
	 * Permet de retirer
	 *
	 * @param $items
	 */
	public function hide($items)
	{
		foreach($items as $key => $value )
		{
			if( is_array($value) )
			{
				return $this->hide($value);
			}
			else
			{
				if( array_key_exists($key, $this->hidden) )
				{
					unset($items[$value]);
				}
			}
		}
	}
}