<?php require_once('../DB/DBConnect.php'); ?>
<?php require_once('../functions/functions.php'); ?>
<?php require_once('../functions/queryFunctions.php'); ?>
<?php require_once('../DB/session.php'); ?>
<?php require_once ('adminConstants.php'); ?>
<?php

/*
 * This file is in control of handling the "request" of deleting a 
 * specific admin account. The request is initiated in admin.php, when 
 * the admin accounts are listed (when url is admin.php?u). When the 
 * "Remove this user" link is pressed, a POST request is sent to
 * processor.php, which then moves the admin-to-delete's id that is stored
 *  in the POST request to the session variable. The page then redirects 
 * to this page, where the original request to delete admin is fulfilled.
 * This file uses a prepared statement to perform its deletion query.
 */

if (isset($_SESSION['deleteAdminUser'])) {
    global $DBConnect;
    $result = 0;

    $id = $_SESSION['deleteAdminUser'];
    unset($_SESSION['deleteAdminUser']); //remove data from session
    
    //Prevent Users From Deleting Super Admins. Prevent Non topadmins from
    //deleting admins
    /*     * **********************************************
     * MAY NEED TO CHANGE THIS WHEN MIGRATED TO
     * RECLAIM!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * ********************************************** */
    if (!isTopAdmin(getCurrentlyLoggedId()) || isTopAdmin($id)) {
        $_SESSION['message'] = INVALID_AUTHORITY_MESSAGE;
        redirect('../../admin.php?u');
    } else {
        //Init statement
        $stmt = mysqli_stmt_init($DBConnect);

        //Create plain statement
        $query = "DELETE FROM admin WHERE id = ? LIMIT 1";

        //Make prepared statement. If successful, run query
        if (mysqli_stmt_prepare($stmt, $query)) {

            //Bind params to statement
            mysqli_stmt_bind_param($stmt, "i", $id);

            //Execute query
            $result = mysqli_stmt_execute($stmt);

            //Close statement
            mysqli_stmt_close($stmt);
        }

        //Check result
        if ($result) {
            $_SESSION['message'] = "Admin User Deleted Successfully";
        } else {
            // DELETE Failed
            $_SESSION['message'] = "Admin User Deletion Failed.\n";
            //$_SESSION['message'] .= mysqli_error($DBConnect);
        }
        redirect('../../admin.php?u'); //Send back to admin page
    }
} 
else {
    redirect('../../logout.php');   //Send to logout page.
}
?>