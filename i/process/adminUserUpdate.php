<?php require_once('../DB/DBConnect.php'); ?>
<?php require_once('../functions/functions.php'); ?>
<?php require_once('../functions/queryFunctions.php'); ?>
<?php require_once('../DB/session.php'); ?>
<?php require_once ('adminConstants.php'); ?>
<?php require_once('../functions/utility.php');?>
<?php

if (isset($_POST['adminEdit'])) {
    global $DBConnect;
    
    //FORM VALIDATION
    $errors = array();

    $maxFieldLength = array("name" => 50, "set_username" => 50, "set_password" => 40, "email" => 50);
    $requiredFields = array("name", "set_username", "email");//"set_password", "email");
    $errors = array_merge($errors, checkRequiredFields($requiredFields));
    $errors = array_merge($errors, checkMaxFieldLength($maxFieldLength));

    $result = 0;
    if (empty($errors)) { //If no validation errors
        $userID = $_POST['adminUserForm']; //Get ID of admin being updated 
        
        //If currently logged in admin is top admin
        //or the currently logged in admin is the same as the admin who's being updated,
        //let them update page.
        if (isTopAdmin(getCurrentlyLoggedId()) || $userID == getCurrentlyLoggedId()) {
            $updateUserData = getAdminUserID($userID); //Get admin-to-update's current info

            $name = trim($_POST['name']);   //name
            $username = trim($_POST['set_username']);   //user
            $password = trim($_POST['set_password']);   //password (blank implies no change)
            $email = trim($_POST['email']); //email
            $access = (!empty($_POST['access'])) ? (array_sum($_POST['access'])) : 0; //access

            //Check if password has been updated
            if ($password) { //If not empty, use input as new password
                $passwordEncrypted = encryptPassword($password);//sha1($password);
                $samepass = false;
            } else { //If empty, do not change password
                $passwordEncrypted = $updateUserData['password'];
                $samepass = true;
            }
        } else {
            $noChange = true;
        }
    }



    if (!$noChange) {
        //Init statement
        $stmt = mysqli_stmt_init($DBConnect);

        //Plaintext statement
        $query = "UPDATE admin SET
				name = ?,
				username = ?,
				password = ?,
				email = ?,
				access = ?
				WHERE id = ?";

        //Make prepared statement. If successful, run query
        if (mysqli_stmt_prepare($stmt, $query)) {
            //Bind params to statement
            mysqli_stmt_bind_param($stmt, "sssssi", $name, $username, $passwordEncrypted, $email, $access, $userID);
            
            //Execute
            if (mysqli_stmt_execute($stmt)) {
                //SUCCESS
                $_SESSION['message'] .= "Admin User Updated Successfully";
                // $_SESSION['message'] .= $name . "" . $username ."". $email . "Is top admin?:" . (isTopAdmin(getCurrentlyLoggedId())?"yes":"no");
            } else {
                //FAILURE
                $_SESSION['message'] = "Admin User Update Failed - If the problem persists, contact your server administrator.\n"
                         . "Make sure username is unique.";
                $_SESSION['message'] .= mysqli_error($DBConnect);
                $_SESSION['message'] .= $passwordEncrypted;
            }
        }

        // Close Statement 
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = INVALID_AUTHORITY_MESSAGE;
    }
}
?>