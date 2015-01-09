<?php
/**
* AdminAJAXRequestModel - glue between the database and Controller
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

class AdminAJAXRequestModel extends AJAXRequestModel
{
    /**
    * Add a new post
    * @param string $title   Title of the new post
    * @param string $content Body text of the post
    * @param bool   $draft   Is the post public yet
    * @return none
    */
    public function newPost($title, $content, $draft)
    {
        $draft = ($draft == "true") ? 1 : 0; //bool to int
        $this->database->runQuery(
            "INSERT INTO blog_posts(" .
            "post_timestamp,post_title,post_content,post_draft,post_tweeted" .
            ") VALUES(:timestamp, :title, :content, :draft, 0)",
            array(
                ":timestamp" => time(),
                ":title" => $title,
                ":content" => $content,
                ":draft" => $draft
            )
        );
        $id = $this->database->lastInsertedID();
        $this->tweetPost($id); //Tweet this
    }

    /**
    * Update a post
    * @param int    $postid  ID of the post to update
    * @param string $title   Title of the post
    * @param string $content Body text of the post
    * @param bool   $draft   Is the post public
    * @return none
    */
    public function updatePost($postid, $title, $content, $draft)
    {
        $draft = ($draft == "true") ? 1 : 0; //bool to int
        $this->database->runQuery(
            "UPDATE blog_posts SET post_title = :ti, post_content = :txt, " .
            "post_draft = :draft WHERE post_id = :pid LIMIT 1",
            array(
                ":ti" => $title,
                ":txt" => $content,
                ":draft" => $draft,
                ":pid" => $postid
            )
        );
        $this->tweetPost($postid);
    }

    /**
    * Update a page
    * @param int    $pageid  ID of the page to update
    * @param string $content Body text of the page
    * @return none
    */
    public function updatePage($pageid, $content)
    {
        $this->database->runQuery(
            "UPDATE site_pages SET page_content = :content " .
            " WHERE page_id = :pageid LIMIT 1",
            array(":content" => $content, ":pageid" => $pageid)
        );
    }

    /**
    * Add an IP address to the blacklist
    * @param string $ip IP address to block
    * @return none
    */
    public function blockIP($ip)
    {
        if (parent::checkIP($ip) != 0) {
            return; //do nothing if already blocked
        }
        $this->database->runQuery(
            "INSERT INTO blocked_addresses(address, blocked_timestamp)" .
            " VALUES(:ip, :timestamp)",
            array(":ip" => $ip, ":timestamp" => time())
        );
    }

    /**
    * Remove an IP address from the blacklist
    * @param string $ip IP address to be unblocked
    * @return none
    */
    public function unblockIP($ip)
    {
        $this->database->runQuery(
            "DELETE FROM blocked_addresses WHERE address = :ip",
            array(":ip" => $ip)
        );
    }

    /**
    * Change a user password
    * @param string $currentp   Current user password
    * @param string $newp       Intended new password
    * @param string $confirmedp Verification of the new password
    * @return bool True on updated, False on error
    */
    public function changePassword($currentp, $newp, $confirmedp)
    {
        if ($newp != $confirmedp) {
            return false; //Passwords dont match
        }

        $data = $this->database->runQuery(
            "SELECT username FROM site_users WHERE user_id='1'",
            array()
        );

        $row = $this->database->getRow($data);

        if (!$this->checkCredentials($row[0], $currentp)) {
            return false; //Current password is wrong
        }
        $hash = $this->hashPassword($newp);

        $this->database->runQuery(
            "UPDATE site_users SET password='$hash' WHERE user_id='1'",
            array()
        );

        return true;
    }

    /**
    * Check if supplied credentials match the database (login function)
    * @param string $username Input username
    * @param string $password Input password
    * @return bool True when verified, False otherwise
    */
    public function checkCredentials($username, $password)
    {
        $result = $this->database->runQuery(
            "SELECT password FROM site_users WHERE username = :username",
            array(":username" => $username)
        );

        if ($this->database->getNumRows($result) == 1) {
            $dbhash = $this->database->getRow($result);
            if (password_verify($password, $dbhash[0])) {
                $_SESSION['user'] = $username;
                return true;
            }
        }
        return false;
    }

    /**
    * Send a tweet about a new post
    * @param int $postid Id of the post to be tweeted
    * @return none
    */
    public function tweetPost($postid)
    {
        if (!isset($postid)) {
            return; //Post ID not set, maybe newPost() failed
        }
        $post = parent::getSinglePost($postid);
        if ($this->database->GetNumRows($post) == 0) {
            return; //Post doesnt exist or is a draft
        }

        $row = $this->database->getRow($post);
        if ($row['post_tweeted'] == "1") {
            return; //Already tweeted out
        }

        $url = parent::getBaseURL() . "blog/" . $row['post_id'];

        $tweet = "New Blog Post: " . $row['post_title'] . " - " . $url;

        $twitter = new \ABirkett\classes\TwitterOAuth(
            TWITTER_CONSUMER_KEY,
            TWITTER_CONSUMER_SECRET,
            TWITTER_OAUTH_TOKEN,
            TWITTER_OAUTH_SECRET
        );
        $twitter->post('statuses/update', array('status' => $tweet));

        $this->database->runQuery(
            "UPDATE blog_posts SET post_tweeted=1 WHERE post_id = :postid",
            array(":postid" => $postid)
        );
    }

    /**
    * Generate a new password hash using a random salt
    * @param string $password Plain text password
    * @return string Password hash
    */
    public function hashPassword($password)
    {
        $options = [
            'cost' => 10,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}
