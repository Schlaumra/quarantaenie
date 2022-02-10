<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/edit/quarantine.php');

$db = new QuarantaenieDB();

if (!($_GET['id'] ?? false))
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
$quarantine = $db->getQuarantineById($_GET['id']);
if (!($quarantine))
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}

?>
<html lang="de">
<head>
    <title>Quarantänie</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <form action="../actions/quarantine.php?action=edit&qtID=<?php echo $quarantine['id']?>" method="post">
        <label for="student">Schüler:</label>
        <select id="student" name="student_fk" required>
            <?php
            foreach($db->queryStudentGenerator() as $student)
            {
                $selected = $student['id'] == $quarantine['student_fk'] ? 'selected' : '';
                $id = $student['id'];
                $firstName = $student['firstName'];
                $lastName = $student['lastName'];
                echo "<option value=\"$id\" $selected>$firstName $lastName</option>";
            }
            ?>
        </select>
        <label for="start">Start:</label>
        <input id="start" type="date" name="qStart" value="<?php echo $quarantine['qStart']?>" required>
        <label for="end">Ende:</label>
        <input id="end" type="date" name="qEnd" value="<?php echo $quarantine['qEnd']?>" required>
        <input type="submit">
    </form>
</div>
</body>
</html>