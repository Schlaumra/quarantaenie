<html lang="de">
<head>
    <title>Login</title>
    <?php include 'modules/header.php'?>
</head>
<body>
<?php include 'modules/header-bar.php'?>
<div class="content">
    <div class="login-form-wrap">
        <h2>Login</h2>
        <p style="font-weight: bold"><?php
            session_start();
            if($_SESSION['failedLogin'] ?? false)
                echo "Failed Login";
            else
                echo "Welcome User";
            ?>
        </p>
        <form class="login-form" action="actions/login.php" method="post">
            <label for="username">User:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" class="login" value="Login">
        </form>
    </div>
</div>
</body>
</html>