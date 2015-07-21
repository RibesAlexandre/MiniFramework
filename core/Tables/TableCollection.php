<?php
namespace Core\Tables;


class TableCollection implements \IteratorAggregate, \ArrayAccess
{
	public $items = [];

	public function __construct(array $items)
	{
		$this->items = $items;
	}

	/**
	 * Retourne la clé d'un tableau
	 *
	 * @param $key
	 * @return \Core\Collection|null
	 */
	public function get($key)
	{
		if( $this->has($key) )
		{
			return $this->items[$key];
		}
		return null;
	}

	/**
	 * Associe une valeur à une clé dans le tableau
	 *
	 * @param $key
	 * @param $value
	 */
	public function set($key, $value)
	{
		$this->items[$key] = $value;
	}

	/**
	 * Vérifie si le tableau possède bien la clé
	 *
	 * @param $key
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->items);
	}

	/**
	 * @param $key
	 * @param $value
	 * @return \Core\Tables\TableCollection
	 */
	public function listing($key, $value)
	{
		$results = [];
		foreach( $this->items as $item )
		{
			$results[$item[$key]] = $item[$value];
		}
		return new TableCollection($results);
	}

	/**
	 * Récupère des éléments précis d'un tableau en fonction de la clé
	 *
	 * @param $key
	 * @return \Core\Collection
	 */
	public function extract($key)
	{
		$results = [];
		foreach($this->items as $item)
		{
			$results[] = $item[$key];
		}
		return new Collection($results);
	}

	/**
	 * Permet d'associer des clés de tableau entre elles
	 *
	 * @param $separator
	 * @return string
	 */
	public function join($separator)
	{
		return implode($separator, $this->items);
	}

	/**
	 * Retourne la valeur maximale du tableau ou d'une clé
	 *
	 * @param bool|FALSE $key
	 * @return mixed
	 */
	public function max($key = false)
	{
		if( $key )
		{
			return $this->extract($key)->max();
		}
		return max($this->items);
	}

	/**
	 * retourne la valeur minimale du tableau ou d'une clé
	 *
	 * @param bool|FALSE $key
	 * @return mixed
	 */
	public function min($key = false)
	{
		if( $key )
		{
			return $this->extract($key)->min();
		}
		return min($this->items);
	}

	/**
	 * @param $offset
	 * @param $value
	 */
	public function offsetSet($offset, $value)
	{
		return $this->set($offset, $value);
	}

	/**
	 * @param $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return $this->has($offset);
	}

	/**
	 * @param $offset
	 */
	public function offsetUnset($offset)
	{
		if( $this->has($offset) )
		{
			unset($this->items[$offset]);
		}
	}

	/**
	 * @param $offset
	 * @return \Core\Collection|null
	 */
	public function offsetGet($offset)
	{
		return $this->get($offset);
	}

	/**
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->items);
	}
}