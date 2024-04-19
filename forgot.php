<?php require_once('i/DB/DBConnect.php'); ?>
<?php require_once('i/DB/session.php'); ?>
<?php require_once('i/functions/functions.php'); ?>
<?php require_once('i/functions/queryFunctions.php'); ?>
<?php require_once('i/functions/utility.php');?>
<?php require("i/layout/header.php"); ?>
</head>
<body>
    <section id="login" class="dropShadow_deep">
        <h1>Forgot Password</h1>
        <form id="loginForm" action="forgotSubmit.php" method="post">
            <div id="loginMain">
                <div class="row">
                    <p class="col">Email:</p>
                    <input type="email" name="email" value="name@example.com" id="email" class="col"/>
                </div>
            </div>
            <input type="submit" name="submit" value="Submit" id="submit" />
        </form>
        <br />
        <a href="https://digitalfarmingtonmap.org/login.php"><< Go Back to Login</a>
    </section>
</body>
</html>