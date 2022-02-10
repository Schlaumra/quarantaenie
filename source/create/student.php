<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/create/student.php');

$db = new QuarantaenieDB();

?>
<html lang="de">
<head>
    <title>Quarantänie</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <form action="../actions/student.php?action=add" method="post">
        <label>
            Vorname:
            <input type="text" name="firstName" required>
        </label>
        <label>
            Nachname:
            <input type="text" name="lastName" required>
        </label>
        <label>
            Klasse:
            <select name="class_fk" required>
                <?php
                    $reqClass = $_GET['clID'] ?? null;
                    foreach($db->queryClassGenerator() as $class)
                    {
                        $id = $class['id'];
                        $selected = $reqClass == $id ? 'selected' : '';
                        $name = $class['name'];
                        echo "<option value=\"$id\" $selected>$name</option>";
                    }
                ?>
            </select>
        </label>
        <input type="submit">
    </form>
</div>
</body>
</html>