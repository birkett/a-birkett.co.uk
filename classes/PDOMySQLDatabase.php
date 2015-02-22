<?php
/**
 * Basic wrapper for working with a MySQL database via PDO
 *
 * PHP Version 5.4
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.a-birkett.co.uk
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
                'mysql:host='.DATABASE_HOSTNAME.';dbname='.
                DATABASE_NAME.';port='.DATABASE_PORT,
                DATABASE_USERNAME,
                DATABASE_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (\PDOException $e) {
            echo 'DB no work :(';
        }

    }//end __construct()


    /**
     * Open a database handle
     * @return object Database handle
     */
    public static function getInstance()
    {
        static $database = null;
        if (isset($database) === false) {
            $database = new PDOMySQLDatabase();
        }

        return $database;

    }//end getInstance()


    /**
     * Destructor
     * @return none
     */
    public function __destruct()
    {
        $this->mLink = null;

    }//end __destruct()


    /**
     * Get MySQL server version info
     * @return string MySQL Server version
     */
    public function serverInfo()
    {
        if ($this->mLink === null) {
            return;
        }

        return $this->mLink->getAttribute(PDO::ATTR_SERVER_VERSION);

    }//end serverInfo()


    /**
     * Run a query
     * @param  string $query  Query string to run.
     * @param  array  $params Array of parameters to bind.
     * @return array  Array of results
     */
    public function runQuery($query, $params = array())
    {
        if ($this->mLink === null) {
            return;
        }

        $statement = $this->mLink->prepare($query);
        $statement->execute($params);
        if ($statement->columnCount() !== 0) {
            return $statement->fetchAll();
        }

    }//end runQuery()


    /**
     * Get single row from a result, until no results left
     * @param  array $result Array of rows.
     * @return array One row array or null when none left
     */
    public function getRow(&$result)
    {
        if ($result === false) {
            return;
        }

        if (count($result) !== 0) {
            return array_shift($result);
        } else {
            return null;
        }

    }//end getRow()


    /**
     * Get number of rows
     * @param array $result Array of results.
     * @return int  Number of rows in result
     */
    public function getNumRows($result)
    {
        if ($result === false) {
            return;
        }

        return count($result);

    }//end getNumRows()


    /**
     * Get the last inserted row ID
     * @return string Row ID
     */
    public function lastInsertedID()
    {
        if ($this->mLink === null) {
            return null;
        }

        return $this->mLink->lastInsertId();

    }//end lastInsertedID()
}//end class
