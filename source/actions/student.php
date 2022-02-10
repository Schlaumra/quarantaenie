<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/actions/student.php');

$db = new QuarantaenieDB();

$action = $_GET['action'] ?? null;

if (!$action)
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}

if ($action == 'add')
{
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $class_fk = $_POST['class_fk'] ?? null;
    if ($firstName && $lastName && $class_fk)
    {
        $db->insertStudent($firstName, $lastName, $class_fk);
    }
}
elseif ($action == 'edit')
{
    $id = $_GET['stID'] ?? null;
    $firstName = $_POST['firstName'] ?? null;
    $lastName = $_POST['lastName'] ?? null;
    $class_fk = $_POST['class_fk'] ?? null;

    if ($id and $firstName and $lastName and $class_fk)
    {
        $db->updateStudentById($id, $firstName, $lastName, $class_fk);
    }
}
elseif ($action == 'delete') {
    $id = $_GET['stID'] ?? null;
    if ($id)
    {
        $db->deleteQuarantineByStudentId($id);
        $db->deleteStudentById($id);
    }
}

$backlink = $_SESSION['backlink'] ?? '/index.php';
header("HTTP/1.1 303 See Other");
header("Location: $backlink");
exit();