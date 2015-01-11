<?php
/**
* Basic wrapper for working with a MySQL database via PDO
*
* PHP Version 5.5
*
* @category Classes
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\classes;

use PDO;

class PDOMySQLDatabase
{
    /**
    * Store the current link to avoid reconnections
    * @var object $mLink
    */
    private $mLink;

    /**
    * Constructor
    * @return none
    */
    private function __construct()
    {
        try {
            $this->mLink = new PDO(
                "mysql:host=" . DATABASE_HOSTNAME .
                ";dbname=" . DATABASE_NAME .
                ";port=" . DATABASE_PORT,
                DATABASE_USERNAME,
                DATABASE_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (\PDOException $e) {
            echo "DB no work :(";
        }
    }

    /**
    * Open a database handle
    * @return object Database handle
    */
    public static function getInstance()
    {
        static $database = null;
        if (!isset($database)) {
            $database = new PDOMySQLDatabase();
        }
        return $database;
    }

    /**
    * Destructor
    * @return none
    */
    public function __destruct()
    {
        $this->mLink = null;
    }

    /**
    * Get MySQL server version info
    * @return string MySQL Server version
    */
    public function serverInfo()
    {
        if (!$this->mLink) {
            return;
        }
        return $this->mLink->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    /**
    * Run a query
    * @param string  $query  Query string to run
    * @param mixed[] $params Array of parameters to bind
    * @return mixed[] Array of results
    */
    public function runQuery($query, $params = array())
    {
        if (!$this->mLink) {
            return;
        }
        $statement = $this->mLink->prepare($query);
        $statement->execute($params);
        if ($statement->columnCount() != 0) {
            return $statement->fetchAll();
        }
    }

    /**
    * Get single row from a result, until no results left
    * @param mixed[] $result Array of rows
    * @return mixed[] One row array or null when none left
    */
    public function getRow(&$result)
    {
        if (!$result) {
            return;
        }
        if (count($result) != 0) {
            return array_shift($result);
        } else {
            return null;
        }
    }

    /**
    * Get number of rows
    * @param mixed[] $result Array of results
    * @return int Number of rows in result
    */
    public function getNumRows($result)
    {
        if (!$result) {
            return;
        }
        return count($result);
    }

    /**
    * Get the last inserted row ID
    * @return string Row ID
    */
    public function lastInsertedID()
    {
        if (!$this->mLink) {
            return null;
        }
        return $this->mLink->lastInsertId();
    }
}
