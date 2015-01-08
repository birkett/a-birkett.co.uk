<?php
//-----------------------------------------------------------------------------
// Admin functions.
//
//  !!!These are generally more risky than the front end functions. Hence
//      the separation!!!
//-----------------------------------------------------------------------------
namespace ABirkett;

//-----------------------------------------------------------------------------
// Check if a user is logged in with a valid session
//      In: none
//      Out: TRUE on logged in, FALSE if not
//-----------------------------------------------------------------------------
function IsLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

//-----------------------------------------------------------------------------
// Destroys a user session - causing a logout
//      In: none
//      Out: none
//-----------------------------------------------------------------------------
function KillSession()
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        session_destroy();
    }
}

//-----------------------------------------------------------------------------
// Define a symbol so public functions can act accordingly on an admin page
//      In: none
//      Out: none
//-----------------------------------------------------------------------------
function DeclareAdminPage()
{
    define('ADMINPAGE', 1);
}
