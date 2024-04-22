<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/DB/session.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('i/functions/utility.php');?>
<?php require_once('i/functions/adminManagerFunctions.php');?>
<?php require("i/layout/header.php"); ?>
<?php
            $link = "#";
            // Check if form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the email from the form
                $email = $_POST['email'];
                $admin = getAdminEmail($email);
                //if no rows are returned, fetch_array will return false
                //CHANGED SQLI 
                if ($admin){
                    // Generate a password reset token
                    $token = bin2hex(random_bytes(32));
                    // Save the token in the database with an expiration time (e.g., 1 hour)
                    $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    $query = "UPDATE admin SET reset_token = '$token', reset_expiration = '$expiration' WHERE email = '$email'";
                    $result = mysqli_query($DBConnect, $query);
                    confirmQuery($result);

                    // Send password reset email
                    $resetLink = "https://digitalfarmingtonmap.org/recover.php?token=$token";
                    $subject = 'Password Reset Request';
                    $message = "Click the following link to reset your password: $resetLink";
                    $headers = 'From: noreply@digitalfarmington.org';

                    mail($email, $subject, $message, $headers);
                } else {
                    return NULL;
                }
            }
        ?>
</head>
<body>
    <section id="login" class="dropShadow_deep">
        <h1>Check email for password reset link</h1>
    </section>
</body>
</html>

