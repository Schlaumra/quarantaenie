<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/create/quarantine.php');

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
    <form action="../actions/quarantine.php?action=add" method="post">
        <label>
            Schüler:
            <select name="student_fk" required>
                <?php
                $reqStudent = $_GET['stID'] ?? null;
                foreach($db->queryStudentGenerator() as $student)
                {
                    $id = $student['id'];
                    $selected = $reqStudent == $id ? 'selected' : '';
                    $firstName = $student['firstName'];
                    $lastName = $student['lastName'];
                    echo "<option value=\"$id\" $selected>$firstName $lastName</option>";
                }
                ?>
            </select>
        </label>
        <label>
            Start:
            <input type="date" name="qStart" required>
        </label>
        <label>
            Ende:
            <input type="date" name="qEnd" required>
        </label>
        <input type="submit">
    </form>
</div>
</body>
</html>