<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/edit/student.php');

$db = new QuarantaenieDB();

if (!($_GET['id'] ?? false))
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
$student = $db->getStudentById($_GET['id']);
if (!($student))
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
?>
<html lang="de">
<head>
    <title>Schüler</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <form action="../actions/student.php?action=edit&stID=<?php echo $student['id']?>" method="post">
        <label>
            Vorname:
            <input type="text" name="firstName" value="<?php echo $student['firstName']?>" required>
        </label>
        <label>
            Nachname:
            <input type="text" name="lastName" value="<?php echo $student['lastName']?>" required>
        </label>
        <label>
            Klasse:
            <select name="class_fk" required>
                <?php
                foreach($db->queryClassGenerator() as $class)
                {
                    $selected = $class['id'] == $student['class_fk'] ? 'selected' : '';
                    $id = $class['id'];
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