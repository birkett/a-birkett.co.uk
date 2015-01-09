<?php
//-----------------------------------------------------------------------------
// Database class
//
//  Basic class to interface with a MySQL database via PDO
//-----------------------------------------------------------------------------
namespace ABirkett\classes;

use PDO;

class PDOMySQLDatabase
{
    private $mLink;

    //-----------------------------------------------------------------------------
    // Constructor
    //      In: Database name
    //      Out: none
    //-----------------------------------------------------------------------------
    private function __construct()
    {
        try {
            $this->mLink = new PDO(
                "mysql:host=" . DATABASE_HOSTNAME . ";dbname=" . DATABASE_NAME . ";port=" . DATABASE_PORT,
                DATABASE_USERNAME,
                DATABASE_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (\PDOException $e) {
            echo "DB no work :(";
        }
    }

    //-----------------------------------------------------------------------------
    // Open a database handle
    //		In: none
    //		Out: Database object
    //  Store the current database object to prevent multiple connections
    //-----------------------------------------------------------------------------
    public static function getInstance()
    {
        static $database = null;
        if (!isset($database)) {
            $database = new PDOMySQLDatabase();
        }
        return $database;
    }

    //-----------------------------------------------------------------------------
    // Destructor
    //      In: none
    //      Out: none
    //-----------------------------------------------------------------------------
    public function __destruct()
    {
        $this->mLink = null;
    }

    //-----------------------------------------------------------------------------
    // Get MySQL server version info
    //      In: none
    //      Out: Version string
    //-----------------------------------------------------------------------------
    public function serverInfo()
    {
        if (!$this->mLink) {
            return;
        }
        return $this->mLink->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    //-----------------------------------------------------------------------------
    // Run a query
    //      In: Query string
    //      Out: MySQLi result
    //-----------------------------------------------------------------------------
    public function runQuery($query, $params)
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

    //-----------------------------------------------------------------------------
    // Get single row from a result
    //      In: MySQLi result
    //      Out: Single row
    //   Returns next row on each call until end, then NULL
    //-----------------------------------------------------------------------------
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

    //-----------------------------------------------------------------------------
    // Get number of rows
    //      In: MySQLi result
    //      Out: Number of rows (can be fetched with GetRow()
    //-----------------------------------------------------------------------------
    public function getNumRows($result)
    {
        if (!$result) {
            return;
        }
        return count($result);
    }
}
