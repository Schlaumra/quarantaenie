<?php

require_once '../inc/require.php';

checkSession('/create/class.php');

?>
<html lang="de">
<head>
    <title>Quarantänie</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <form action="../actions/class.php?action=add" method="post">
        <label>
            Name:
            <input type="text" name="name" required>
            <input type="submit">
        </label>
    </form>
</div>
</body>
</html>