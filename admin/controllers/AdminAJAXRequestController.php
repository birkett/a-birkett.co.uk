<?php
//-----------------------------------------------------------------------------
// Handle private, admin, AJAX requests
//      In: Request POST data
//      Out: Status message
//-----------------------------------------------------------------------------
namespace ABirkett;

class AdminAJAXRequestController extends AJAXRequestController
{
    //-----------------------------------------------------------------------------
    // Create a new post
    //      In: Title, Content, Draft
    //      Out: none
    //-----------------------------------------------------------------------------
    private function newPost($title, $content, $draft)
    {
        $db = GetDatabase();
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
    private function updatePost($postid, $title, $content, $draft)
    {
        $draft = ($draft == "true") ? 1 : 0; //bool to int
        GetDatabase()->runQuery(
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
    private function updatePage($pageid, $content)
    {
        GetDatabase()->runQuery(
            "UPDATE site_pages SET page_content = :content WHERE page_id = :pageid LIMIT 1",
            array(":content" => $content, ":pageid" => $pageid)
        );
    }

    //-----------------------------------------------------------------------------
    // Blocks an IP address
    //      In: IP Address
    //      Out: none
    //-----------------------------------------------------------------------------
    private function blockIP($ip)
    {
        if (parent::checkIP($ip) != 0) {
            return; //do nothing if already blocked
        }
        GetDatabase()->runQuery(
            "INSERT INTO blocked_addresses(address, blocked_timestamp) VALUES(:ip, :timestamp)",
            array(":ip" => $ip, ":timestamp" => time())
        );
    }

    //-----------------------------------------------------------------------------
    // Unblocks an IP address
    //      In: IP Address
    //      Out: none
    //-----------------------------------------------------------------------------
    private function unblockIP($ip)
    {
        GetDatabase()->runQuery("DELETE FROM blocked_addresses WHERE address = :ip", array(":ip" => $ip));
    }

    //-----------------------------------------------------------------------------
    // Changes the admin password
    //      In: Current password, New password and New password again (confirm)
    //      Out: none
    //-----------------------------------------------------------------------------
    private function changePassword($currentpassword, $newpassword, $confirmedpassword)
    {
        if ($newpassword != $confirmedpassword) {
            return false; //Passwords dont match
        }
        $db = GetDatabase();
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
    private function checkCredentials($username, $password)
    {
        $db = GetDatabase();
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
    private function tweetPost($postid)
    {
        $db = GetDatabase();
        $post = getPosts("single", $postid, false);
        if ($db->GetNumRows($post) == 0) {
            return; //Post doesnt exist or is a draft
        }
        list($id, $timestamp, $title, $content, $draft, $post_tweeted) = $db->getRow($post);
        if ($post_tweeted == 1) {
            return; //Already tweeted out
        }

        GetBaseURL();
        $url = GetBaseURL() . "blog/" . $id;

        $tweet = "New Blog Post: " . $title . " - " . $url;

        $twitter = new TwitterOAuth(
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
    private function hashPassword($password)
    {
        $options = [
            'cost' => 10,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function __construct()
    {
        switch($_POST['mode']) {
            //Edit post mode
            case "editpost":
                if (
                    !isset($_POST['postid']) ||
                    !is_numeric($_POST['postid']) ||
                    !isset($_POST['title']) ||
                    !isset($_POST['content']) ||
                    !isset($_POST['draft'])
                ) {
                    parent::badRequest("Something was rejected. Check all fields are correct.");
                } else {
                    $this->updatePost($_POST['postid'], $_POST['title'], $_POST['content'], $_POST['draft']);
                    parent::goodRequest("Post updated.");
                }
                break;
            //Edit page mode
            case "editpage":
                if (!isset($_POST['pageid']) || is_numeric($_POST['pageid'] || !isset($_POST['content']))) {
                    parent::badRequest("Something was rejected. Check all fields are correct.");
                } else {
                    $this->updatePage($_POST['pageid'], $_POST['content']);
                    parent::goodRequest("Page updated.");
                }
                break;
            //New post mode
            case "newpost":
                if ($_POST['title'] == "" || $_POST['content'] == "" || !isset($_POST['draft'])) {
                    parent::badRequest("Something was rejected. Check all fields are correct.");
                } else {
                    $this->newPost($_POST['title'], $_POST['content'], $_POST['draft']);
                    parent::goodRequest("Posted!");
                }
                break;
            //Add blocked IP mode
            case "addip":
                if (!isset($_POST['ip']) || $_POST['ip'] == "") {
                    parent::badRequest("No address specified");
                } else {
                    $this->blockIP($_POST['ip']);
                    parent::goodRequest("Address " . $_POST['ip'] . " was blocked");
                }
                break;
            //Remove blocked IP mode
            case "removeip":
                if (!isset($_POST['ip']) || $_POST['ip'] == "") {
                    parent::badRequest("No address specified");
                } else {
                    $this->unblockIP($_POST['ip']);
                    parent::goodRequest("Address " . $_POST['ip'] . " was unblocked");
                }
                break;
            //Change the admin password
            case "password":
                if (!isset($_POST['cp']) || !isset($_POST['np']) || !isset($_POST['cnp'])) {
                    parent::badRequest();
                } else {
                    if ($this->changePassword($_POST['cp'], $_POST['np'], $_POST['cnp'])) {
                        parent::goodRequest("Password changed.");
                    } else {
                        parent::badRequest("Failed. Check new passwords match.");
                    }
                }
                break;
            //Login
            case "login":
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    if ($this->checkCredentials($_POST['username'], $_POST['password'])) {
                        parent::goodRequest();
                    } else {
                        parent::badRequest("Incorrect username or password.");
                    }
                }
                break;
        }
    }
}
