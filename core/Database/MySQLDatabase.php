<?php
namespace Core\Database;

use \PDO;

/**
 * Class MySQLDatabase
 *
 * @package Core\Database
 */
class MySQLDatabase extends Database
{
	protected $pdo;

	protected $db_name;
	protected $db_user;
	protected $db_pass;
	protected $db_host;

	public function __construct($db_name)
	{
		parent::__construct($db_name);
	}

	/*
	  * Retourne une instance de PDO
	  */
	protected function getPDO()
	{
		if( $this->pdo === null )
		{
			$pdo = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->db_host, $this->db_user, $this->db_pass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this->pdo = $pdo;
		}

		return $this->pdo;
	}

	/**
	 * Exécute une requête et retourne un résultat ou un tableau
	 * content des résultats
	 *
	 * @param      $statement
	 * @param bool $one
	 * @return array|mixed
	 */
	public function query($statement, $one = false)
	{
		$sql = $this->getPDO()->query($statement);
		$sql->setFetchMode(PDO::FETCH_OBJ);

		$data = $one ? $sql->fetch() : $sql->fetchAll();
		return $data;
	}

	/**
	 * Exécute une requête préparée avec des attributs et retourne
	 * un résultat ou un tableau contenant des résultats
	 *
	 * @param      $statement
	 * @param      $attributes
	 * @param bool $one
	 * @return array|mixed
	 */
	public function prepare($statement, $attributes, $one = false)
	{
		$query =  $this->getPDO()->prepare($statement);
		$query->execute($attributes);
		$query->setFetchMode(PDO::FETCH_OBJ);

		$data = $one ? $query->fetch() : $query->fetchAll();
		return $data;
	}

	/**
	 * Exécute une requête qui ne retourne pas de résultat
	 *
	 * @param       $statement
	 * @param array $attributes
	 * @return bool|\PDOStatement
	 */
	public function execute($statement, $attributes = [])
	{
		if( !empty($attributes) )
		{
			$query = $this->getPDO()->prepare($statement);
			return $query->execute($attributes);
		}
		else
		{
			return $query = $this->getPDO()->query($statement);
		}
	}

	/**
	 * Retourne la dernière ID enregistrée
	 *
	 * @return string
	 */
	public function lastInsertId()
	{
		return $this->getPDO()->lastInsertId();
	}
}