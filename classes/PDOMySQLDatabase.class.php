<?php
//-----------------------------------------------------------------------------
// Database class
//
//  Basic class to interface with a MySQL database via PDO
//-----------------------------------------------------------------------------
namespace ABirkett;

use PDO;

class PDOMySQLDatabase
{
    private $mLink;
    private $host;
    private $port;
    private $user;
    private $pass;
    private $db;
    
    //-----------------------------------------------------------------------------
    // Constructor
    //      In: Database name
    //      Out: none
    //-----------------------------------------------------------------------------
    public function __construct()
    {
        $this->host = DATABASE_HOSTNAME;
        $this->port = DATABASE_PORT;
        $this->user = DATABASE_USERNAME;
        $this->pass = DATABASE_PASSWORD;
        $this->db   = DATABASE_NAME;

        try {
            $this->mLink = new PDO(
                "mysql:host=$this->host;dbname=$this->db",
                $this->user,
                $this->pass,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT)
            );
        } catch (PDOException $e) {
            echo "DB no work :(";
        }
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
    public function runQuery($query)
    {
        if (!$this->mLink) {
            return;
        }
        return $this->mLink->query($query);
    }
    
    //-----------------------------------------------------------------------------
    // Get single row from a result
    //      In: MySQLi result
    //      Out: Single row
    //   Returns next row on each call until end, then NULL
    //-----------------------------------------------------------------------------
    public function getRow($result)
    {
        if (!$this->mLink) {
            return;
        }
        return $result->fetch(PDO::FETCH_NUM);
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
        return $result->rowCount();
    }
    
    //-----------------------------------------------------------------------------
    // Escape string
    //      In: Raw string
    //      Out: Escaped string
    //-----------------------------------------------------------------------------
    public function escapeString($string)
    {
        if (!$this->mLink) {
            return;
        }
        return $this->mLink->quote($string);
    }
}
