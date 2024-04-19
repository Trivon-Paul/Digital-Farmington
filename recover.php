<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/DB/session.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('i/functions/utility.php');?>

<?php
$login = true;

/* --------------------Form Processing-------------------- */
if (isset($_POST['login'])) {

} else {
    //echo "<script>alert('Please fill out the form');</script>";
}
//mysqli_stmt_close($stmt);
/* --------------------End Form Processing-------------------- */
?>
<?php require("i/layout/header.php"); ?>
<style>
    ::placeholder {
        font-size: 10pt;
    }
</style>
</head>
<body>
    <?php include('i/layout/adminTopNavBar.php'); ?>
    <section id="login" class="dropShadow_deep">
        <h1>Create New Password</h1>
        <form id="loginForm" action="recover.php" method="post" onsubmit="return checkValues()">
            <!--<form id="recoverForm" onsubmit="return checkValues()">-->
            <div id="loginMain">
                <div class="row">
                    <p class="col" style="text-align:left; width: 140px;">Username:</p>
                    <input type="text" name="username" value="" id="username" placeholder="Enter Username" class="col"/>
                </div>
                <div class="row">
                    <p class="col" style="text-align:left; width: 140px;">Enter Password:</p>
                    <input type="password" name="password" value="" placeholder="Enter password" id="password" class="col"/>
                </div>
                <div class="row" style="margin-top: 12px;">
                    <p class="col" style="text-align:left; width: 140px;">Confirm Password:</p>
                    <input type="password" name="password2" placeholder="Re-enter password" value="" id="password2" class="col"/>
                </div>
            </div>
            <input type="submit" name="login" value="Login" id="submit" />
        </form>
    </section>
</body>
<script>
    function checkValues() {
            // Get the values of the input fields
            var input1Value = document.getElementById('password').value;
            var input2Value = document.getElementById('password2').value;

            // Check if either input field is empty
            if (input1Value === '' || input2Value === '') {
                alert('Please fill in both password fields.');
                return false; // Prevent form submission
            }
            // Compare the values
            if (input1Value === input2Value) {
                // allow form submission
                return true;
            } else {
                alert('The passwords you have entered are different. Please re-enter your password.');
                return false;
            }
        }
</script>-->
</html>
