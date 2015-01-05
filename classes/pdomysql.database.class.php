<?php
//-----------------------------------------------------------------------------
// Database class
//
//  Basic class to interface with a MySQL database via PDO
//-----------------------------------------------------------------------------

class PDOMySQLDatabase
{
	private $mLink; //Store the connection link
	private $host, $port, $user, $pass, $db;
	
	//-----------------------------------------------------------------------------
	// Constructor
	//		In: Database name
	//		Out: none
	//-----------------------------------------------------------------------------
	public function __construct()
	{
		$this->host = DATABASE_HOSTNAME;
		$this->port = DATABASE_PORT;
		$this->user = DATABASE_USERNAME;
		$this->pass = DATABASE_PASSWORD;
		$this->db 	= DATABASE_NAME;

		$this->Connect($this->host, $this->port, $this->user, $this->pass, $this->db);
	}

	//-----------------------------------------------------------------------------
	// Destructor
	//		In: none
	//		Out: none
	//-----------------------------------------------------------------------------
	public function __destruct()
	{
		$this->Close();
	}
	
	//-----------------------------------------------------------------------------
	// Close a connection
	//		In: none
	//		Out: none
	//-----------------------------------------------------------------------------
	private function Close()
	{
		if($this->mLink) $this->mLink = null;
	}
	
	//-----------------------------------------------------------------------------
	// Create a connection
	//		In: Database connection details
	//		Out: none
	//-----------------------------------------------------------------------------
	public function Connect($host, $port, $user, $pass, $db)
	{
		$constring = "mysql:host=" . $host . ";dbname=" . $db;
		$this->mLink = new PDO($constring, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	}
	
	//-----------------------------------------------------------------------------
	// Get MySQL server version info
	//		In: none
	//		Out: Version string
	//-----------------------------------------------------------------------------
	public function ServerInfo()
	{
		if(!$this->mLink) return;
		return $this->mLink->getAttribute(PDO::ATTR_SERVER_VERSION);
	}

	//-----------------------------------------------------------------------------
	// Run a query
	//		In: Query string
	//		Out: MySQLi result
	//-----------------------------------------------------------------------------
	public function RunQuery($query)
	{
		if(!$this->mLink) return;
		return $this->mLink->query($query);
	}
	
	//-----------------------------------------------------------------------------
	// Get single row from a result
	//		In: MySQLi result
	//		Out: Single row
	//   Returns next row on each call until end, then NULL
	//-----------------------------------------------------------------------------
	public function GetRow($result)
	{
		if(!$this->mLink) return;
		return $result->fetch(PDO::FETCH_NUM);
	}
	
	//-----------------------------------------------------------------------------
	// Get number of rows
	//		In: MySQLi result
	//		Out: Number of rows (can be fetched with GetRow()
	//-----------------------------------------------------------------------------
	public function GetNumRows($result)
	{
		if(!$result) return;
		return $result->rowCount();
	}
	
	//-----------------------------------------------------------------------------
	// Escape string
	//		In: Raw string
	//		Out: Escaped string
	//-----------------------------------------------------------------------------
	public function EscapeString($string)
	{
		if(!$this->mLink) return;
		return $this->mLink->quote($string);
	}
}
?>