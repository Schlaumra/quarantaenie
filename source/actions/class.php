<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

checkSession('/actions/class.php');

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
    $name = $_POST['name'] ?? null;

    if ($name)
    {
        $db->insertClass($name);
    }
}

elseif ($action == 'edit')
{
    $id = $_GET['clID'] ?? null;
    $name = $_POST['name'] ?? null;

    if ($id and $name)
    {
        $db->updateClassById($id, $name);
    }
}
elseif ($action == 'delete') {
    $id = $_GET['clID'] ?? null;
    if ($id)
    {
        $db->optStudentOutOfClass($id);
        $db->deleteClassById($id);
    }
}

$backlink = $_SESSION['backlink'] ?? '/index.php';
header("HTTP/1.1 303 See Other");
header("Location: $backlink");
exit();