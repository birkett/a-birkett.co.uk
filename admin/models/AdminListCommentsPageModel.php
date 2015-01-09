<?php
/**
* AdminListCommentsPageModel - glue between the database and Controller
*
* PHP Version 5.5
*
* @category AdminModels
* @package  PersonalWebsite
* @author   Anthony Birkett <anthony@a-birkett.co.uk>
* @license  http://opensource.org/licenses/MIT MIT
* @link     http://www.a-birkett.co.uk
*/
namespace ABirkett\models;

class AdminListCommentsPageModel extends AdminBasePageModel
{
    /**
     * Fetch a list of all comments
     * @param string $ip Optional IP address to filter fetched comments
     * @return mixed[] Array of comments data
     */
    public function getAllComments($ip = "")
    {
        if ($ip == "") {
            $filter = " ";
        } else {
            $filter = " WHERE client_ip='$ip'";
        }

        return $this->database->runQuery(
            "SELECT * FROM blog_comments" . $filter .
            "ORDER BY comment_timestamp DESC",
            array()
        );
    }
}
