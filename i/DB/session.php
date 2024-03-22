<?php

/*
 * Session.php  contains all functionality for administrator sessions
 * Any time this file is included, the session is started (or resumed).
 * WARNING: This file has a dependency on 'utility.php', which contains the 
 * functions 'redirect' and 'tobinary' which are used here. This dependency is 
 * only fulfilled when both this file and utility.php are included together. 
 */

session_start();

/*
 * Returns 1 if admin is logged in (based on session cookie's data
 * or lack of data). Session data expected for authenticated admins is
 * set in 'adminLogIn'.
 */

function loggedIn() {
    if (isset($_SESSION['CHA']['CCSUCHA2014']) && $_SESSION['CHA']['CCSUCHA2014'] == "2Trains")
        return 1;
}

/*
 * Returns 1 if admin is logged in. Redirects nonadmins back to login screen.
 */

function confirmLogIn() {
    if (!loggedIn()) {
        redirect('login.php');
    } else {
        return 1;
    }
}

/*
 * Given a user struct (containing an admin ID), log into that admin's account
 * by changing session to contain proper data. This also updates the admin's
 * last login value in DB. 
 */

function adminLogIn($user) {
    global $DBConnect;

    $id = $user['id'];

    //Update last login for admin 

    $result = mysqli_query($DBConnect, "UPDATE admin SET lastLogin = now() WHERE id ='" . $id . "'"); //'". date('Y-m-d H:i:s') ."
    //echo mysqli_error($DBConnect);
    //Set session data
    $_SESSION['CHA']['CCSUCHA2014'] = "2Trains";    //Admin is logged in
    $_SESSION['CHA']['ID'] = $user['id'];           //Admin's id
    $_SESSION['CHA']['Username'] = $user['username']; //Admin's username
    $_SESSION['CHA']['Name'] = $user['name'];        //Admin's name
    $_SESSION['CHA']['Email'] = $user['email'];      //Admin's email
    //app Access
    $accessList = to_binary($user['access']);
    $_SESSION['CHA']['Access']['Admin'] = $accessList[0];

    //Send back to admin pag
    redirect("admin.php");
}

function getCurrentlyLoggedId() {
    return $_SESSION['CHA']['ID'];
}

?>