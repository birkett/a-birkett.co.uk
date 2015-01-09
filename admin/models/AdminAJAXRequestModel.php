<?php
//-----------------------------------------------------------------------------
// Handle private AJAX requests
//-----------------------------------------------------------------------------
namespace ABirkett\models;

class AdminAJAXRequestModel extends AJAXRequestModel
{
    //-----------------------------------------------------------------------------
    // Create a new post
    //      In: Title, Content, Draft
    //      Out: none
    //-----------------------------------------------------------------------------
    public function newPost($title, $content, $draft)
    {
        $db = \ABirkett\GetDatabase();
        $draft = ($draft == "true") ? 1 : 0; //bool to int
        $db->runQuery(
            "INSERT INTO blog_posts(post_timestamp, post_title, post_content, post_draft, post_tweeted) " .
            "VALUES(:timestamp, :title, :content, :draft, 0)",
            array(":timestamp" => time(), ":title" => $title, ":content" => $content, ":draft" => $draft)
        );
        $data = $db->runQuery("SELECT post_id FROM blog_posts ORDER BY post_timestamp DESC LIMIT 1", array());
        $row = $db->getRow($data);
        $this->tweetPost($row['post_id']); //Tweet this if not already done
    }

    //-----------------------------------------------------------------------------
    // Update a given post
    //      In: ID, Title, Content, Draft
    //      Out: none
    //-----------------------------------------------------------------------------
    public function updatePost($postid, $title, $content, $draft)
    {
        $draft = ($draft == "true") ? 1 : 0; //bool to int
        \ABirkett\GetDatabase()->runQuery(
            "UPDATE blog_posts SET post_title = :title, post_content = :content, " .
            "post_draft = :draft WHERE post_id = :postid LIMIT 1",
            array(":title" => $title, ":content" => $content, ":draft" => $draft, ":postid" => $postid)
        );
        $this->tweetPost($postid);
    }

    //-----------------------------------------------------------------------------
    // Update a given page
    //      In: ID, Content
    //      Out: none
    //-----------------------------------------------------------------------------
    public function updatePage($pageid, $content)
    {
        \ABirkett\GetDatabase()->runQuery(
            "UPDATE site_pages SET page_content = :content WHERE page_id = :pageid LIMIT 1",
            array(":content" => $content, ":pageid" => $pageid)
        );
    }

    //-----------------------------------------------------------------------------
    // Blocks an IP address
    //      In: IP Address
    //      Out: none
    //-----------------------------------------------------------------------------
    public function blockIP($ip)
    {
        if (parent::checkIP($ip) != 0) {
            return; //do nothing if already blocked
        }
        \ABirkett\GetDatabase()->runQuery(
            "INSERT INTO blocked_addresses(address, blocked_timestamp) VALUES(:ip, :timestamp)",
            array(":ip" => $ip, ":timestamp" => time())
        );
    }

    //-----------------------------------------------------------------------------
    // Unblocks an IP address
    //      In: IP Address
    //      Out: none
    //-----------------------------------------------------------------------------
    public function unblockIP($ip)
    {
        \ABirkett\GetDatabase()->runQuery("DELETE FROM blocked_addresses WHERE address = :ip", array(":ip" => $ip));
    }

    //-----------------------------------------------------------------------------
    // Changes the admin password
    //      In: Current password, New password and New password again (confirm)
    //      Out: none
    //-----------------------------------------------------------------------------
    public function changePassword($currentpassword, $newpassword, $confirmedpassword)
    {
        if ($newpassword != $confirmedpassword) {
            return false; //Passwords dont match
        }
        $db = \ABirkett\GetDatabase();
        $data = $db->runQuery("SELECT username FROM site_users WHERE user_id='1'", array());
        $row = $db->getRow($data);

        if (!$this->checkCredentials($row[0], $currentpassword)) {
            return false; //Current password is wrong
        }
        $hash = $this->hashPassword($newpassword);

        $db->runQuery("UPDATE site_users SET password='$hash' WHERE user_id='1'", array());
        return true;
    }

    //-----------------------------------------------------------------------------
    // Check if the given username and password is valid
    //      In: Username and Password
    //      Out: TRUE on valid, FALSE on no match
    //-----------------------------------------------------------------------------
    public function checkCredentials($username, $password)
    {
        $db = \ABirkett\GetDatabase();
        $result = $db->runQuery(
        "SELECT password FROM site_users WHERE username = :username",
        array(":username" => $username)
        );

        if ($db->getNumRows($result) == 1) {
            $dbhash = $db->getRow($result);
            if (password_verify($password, $dbhash[0])) {
                $_SESSION['user'] = $username;
                return true;
            }
        }
        return false;
    }

    //-----------------------------------------------------------------------------
    // Send a tweet about a specified post
    //      In: Post ID
    //      Out: none
    //-----------------------------------------------------------------------------
    public function tweetPost($postid)
    {
        $db = \ABirkett\GetDatabase();
        $post = parent::getSinglePost($postid);
        if ($db->GetNumRows($post) == 0) {
            return; //Post doesnt exist or is a draft
        }
        list($id, $timestamp, $title, $content, $draft, $post_tweeted) = $db->getRow($post);
        if ($post_tweeted == 1) {
            return; //Already tweeted out
        }

        $url = parent::getBaseURL() . "blog/" . $id;

        $tweet = "New Blog Post: " . $title . " - " . $url;

        $twitter = new \ABirkett\classes\TwitterOAuth(
            TWITTER_CONSUMER_KEY,
            TWITTER_CONSUMER_SECRET,
            TWITTER_OAUTH_TOKEN,
            TWITTER_OAUTH_SECRET
        );
        $twitter->post('statuses/update', array('status' => $tweet));

        $db->runQuery("UPDATE blog_posts SET post_tweeted=1 WHERE post_id = :postid", array(":postid" => $postid));
    }

    //-----------------------------------------------------------------------------
    // Securely hash a password (not reversible)
    //      In: Plain text password
    //      Out: Hashed password
    // This uses a random salt for extra security
    //-----------------------------------------------------------------------------
    public function hashPassword($password)
    {
        $options = [
            'cost' => 10,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}
