<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * PHP Version 5.3
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

namespace ABirkett\classes;

use PDO;

/**
 * Basic wrapper for working with a MySQL database via PDO.
 *
 * The functions here wrap up the PDO functions, an artifact from the days of
 * old, when the site used mysql_*() for database access.
 *
 * Becase this began life as mysql_*() based code, the return values should be
 * compatible with the old methods, while allowing the input to take advantage
 * of new PDO features, like bound paramters.
 *
 * The majority of this class should be database independant. Changing between
 * MySQL, Postgre, Oracle and SQLite should consist of nothing more than a basic
 * change to the connection string in __construc().
 *
 * @category  Classes
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2015 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */
class PDOMySQLDatabase
{

    /**
     * Store the current link to avoid reconnections
     * @var object $mLink
     */
    private $mLink;


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
     * Constructor
     * @return void
     */
    private function __construct()
    {
        try {
            $this->mLink = new PDO(
                'mysql:host='.DATABASE_HOSTNAME.';dbname='.
                DATABASE_NAME.';port='.DATABASE_PORT.';charset=utf8',
                DATABASE_USERNAME,
                DATABASE_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (\PDOException $exception) {
            echo 'Database error: '.$exception->getMessage();
        }

    }//end __construct()


    /**
     * Destructor
     * @return void
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
    public function runQuery($query, $params)
    {
        if ($this->mLink === null) {
            return;
        }

        $statement = $this->mLink->prepare($query);
        $statement->execute($params);
        if ($statement->columnCount() !== 0) {
            return $statement->fetchAll(PDO::FETCH_CLASS);
        }

        return array();

    }//end runQuery()


    /**
     * Get single row from a result, until no results left
     * @param  array $result Array of rows.
     * @return array One row array or null when none left
     */
    public function getRow(&$result)
    {
        if ($result === null) {
            return null;
        }

        if ($this->getNumRows($result) !== 0) {
            return array_shift($result);
        }

        return null;

    }//end getRow()


    /**
     * Get number of rows
     * @param array $result Array of results.
     * @return int  Number of rows in result
     */
    public function getNumRows($result)
    {
        if ($result === null) {
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
