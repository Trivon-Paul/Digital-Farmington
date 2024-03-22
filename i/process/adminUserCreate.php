<?php require_once('../DB/session.php'); //For current user function (getCurrentUserId)?>
<?php require_once ('adminConstants.php'); //For top admin values (isTopUser) ?>
<?php require_once('../functions/utility.php'); //For password hashing (encryptPassword)?>
<?php
/*
 * Creates user based on passed values from form.
 * Post request is sent from processor.php, but initiated from adminManager.php 
 * when "Create" button is pressed.
 * Uses a prepared statement. 
 */

if (isset($_POST['adminCreate'])) {

    //FORM VALIDATION
    $errors = array();

    $maxFieldLength = array("name" => 50, "set_username" => 50, "set_password" => 50, "email" => 50);
    $requiredFields = array("name", "set_username", "set_password", "email");
    $errors = array_merge($errors, checkRequiredFields($requiredFields));
    $errors = array_merge($errors, checkMaxFieldLength($maxFieldLength));

    $result = 0;
    if (!empty($errors)) { //If validation errors
        $_SESSION['message'] = 'Admin User Creation Failed - Ensure that all fields are entered. (Note: Maximum field length is 50 characters)\n'
                . 'If you continue to experience this issue, please contact administrator.';
    } else { //If not top admin
        if (!isTopAdmin(getCurrentlyLoggedId())) {
            $_SESSION['message'] = INVALID_AUTHORITY_MESSAGE;
        }
        else{ //If valid user and valid admin, execute creation query
            global $DBConnect;

            //Init statement
            $stmt = mysqli_stmt_init($DBConnect);

            //Create plain statement
            $query = "INSERT INTO admin
                        (name, username, password, email, access)
                        VALUES (?,?,?,?,?)";

            //Make prepared statement. If successful, run query
            if (mysqli_stmt_prepare($stmt, $query)) {

                //Get values submitted through form request
                $name = trim($_POST['name']);
                $username = trim($_POST['set_username']);
                $email = trim($_POST['email']);
                $access = (!empty($_POST['access'])) ? decbin(array_sum($_POST['access'])) : 0;
                $password = trim($_POST['set_password']);
                $passwordEncrypted = encryptPassword($password);//sha1($password);

                //Bind params to statement
                mysqli_stmt_bind_param($stmt, "sssss", $name, $username, $passwordEncrypted, $email, $access);

                //Execute query
                $result = mysqli_stmt_execute($stmt);

                //Close statement
                mysqli_stmt_close($stmt);
            }
            
            //Check result
            if ($result) {
                //SUCCESS
                $_SESSION['message'] = "Admin User Created Successfully";
            } else {
                //FAILURE
                $_SESSION['message'] = "Admin User Creation Failed - If the problem persist, contact your server administrator\n"
                        . "Make sure username is unique.";
                //$_SESSION['message'] .= mysqli_error($DBConnect);
            }
        }
    }
}
?>
