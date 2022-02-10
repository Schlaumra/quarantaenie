<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/edit/class.php');

$db = new QuarantaenieDB();

if (!($_GET['id'] ?? false))
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
$class = $db->getClassById($_GET['id']);
if (!($class))
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
?>
<html lang="de">
<head>
    <title>Klasse</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <form action="../actions/class.php?action=edit&clID=<?php echo $class['id']?>" method="post">
        <label>
            Name:
            <input type="text" name="name" value="<?php echo $class['name']?>" required>
            <input type="submit">
        </label>
    </form>
</div>
</body>
</html>