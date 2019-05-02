<?php
namespace Core;

use PDO;
use Exception;

class Model {

	protected $db;

	public function __construct() {

		try
		{
			if(Config::DB_OS === 'windows')
			{
				if(Config::DB_ENGINE === 'mysql')
				{
					$this->db = new PDO("mysql:dbname=".Config::DB_NAME.";charset=utf8;host=".Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD);
					$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				elseif(Config::DB_ENGINE === 'sqlserver')
				{
					$this->db = new PDO("sqlsrv:Server=".Config::DB_HOST.";Database=".Config::DB_NAME, Config::DB_USER, Config::DB_PASSWORD);
					$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
			}
			elseif(Config::DB_OS === 'linux')
			{
				if(Config::DB_ENGINE === 'mysql')
				{
					$this->db = new PDO("mysql:dbname=".Config::DB_NAME.";charset=utf8;host=".Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD);
					$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				elseif(Config::DB_ENGINE === 'sqlserver')
				{
					$this->db = new PDO("dblib:dbname=".Config::DB_NAME.";host=".Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD);
					$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
			}
			else
			{
				throw new \Exception("Verifique as suas configurações", 500);
			}
		}
		catch(Exception $exception)
		{
			throw new \Exception($exception, 500);
		}
	}
}
