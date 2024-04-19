<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/DB/session.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('i/functions/utility.php');?>
<?php
$login = true;

/* --------------------Form Processing-------------------- */
if (isset($_POST['login'])) {

    //FORM VALIDATION
    $errors = array();

    $requiredFields = array("username", "password");
    $errors = array_merge($errors, checkRequiredFields($requiredFields));
    // CHANGED mysqlPrep($_POST['username'])
    // CHANGED mysqlPrep($_POST['password'])
    global $DBConnect;
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    //$passwordEncryped = sha1($password);

    if (empty($errors)) {
        //Since username should be unique, get info for user with given
        //username. Then, compare password hashes.
        $query = "SELECT id, username, name, email, access, password ";
        $query .= "FROM admin ";
        $query .= "WHERE username = ?";// LIMIT 1";
        //$query .= "AND password = ? ";

        $stmt = mysqli_stmt_init($DBConnect);

        // Create Prepared statement 
        if (mysqli_stmt_prepare($stmt, $query)) {
            //bind parameters to dummy variables in query
            mysqli_stmt_bind_param($stmt, 's', $username);//, $passwordEncryped);
            //Execute Query
            mysqli_stmt_execute($stmt);
            //bind result variables
            mysqli_stmt_bind_result($stmt, $id, $username, $name, $email, $access, $passwordToMatch);
        }
        
        //If query had result AND result's password hash matches the given password,
        //set user values (for session), close the mysql statement (so other statements
        //can load) and log in user.
        if (mysqli_stmt_fetch($stmt) && comparePassword($password, $passwordToMatch)){
            //Set user values
            $user['id'] = $id;
            $user['username'] = $username;
            $user['name'] = $name;
            $user['email'] = $email;
            $user['access'] = $access;
            
            //Close mysql statement (prevents query conflicts)
            mysqli_stmt_close($stmt);

            //$message = "User: " . $id . " " . $email . " " . implode(",", $user);
            adminLogIn($user);	//log in		
        } else { //If not correct credentials, return message
            $message = "Login Failed<br />Incorrect Username or Password";
        }
    } else {

        //Error in Update
        $message = "Login Failed<br />All fields are required";
    }
} else {
    // the form has not been submitted
    if (isset($_GET['logout'])) {
        $message = "You are now logged out";
    }
}
/* --------------------End Form Processing-------------------- */
?>
<?php require("i/layout/header.php"); ?>
</head>
<body>
    <?php include('i/layout/adminTopNavBar.php'); ?>
    <section id="login" class="dropShadow_deep">
        <h1>Administrator Login</h1>
        <p class="message"><?php echo $message; ?>&nbsp;</p>
        <form id="loginForm" action="login.php" method="post">
            <div id="loginMain">
                <div class="row">
                    <p class="col">Username:</p>
                    <input type="text" name="username" value="" id="username" class="col"/>
                </div>
                <div class="row">
                    <p class="col">Password:</p>
                    <input type="password" name="password" value="" id="password" class="col"/>
                </div>
            </div>
            <input type="submit" name="login" value="Login" id="submit" />
        </form>
        <br />
        <a href="https://digitalfarmingtonmap.org/forgot.php">Forgot Password</a>
    </section>
</body>
</html>