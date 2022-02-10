<?php

require_once '../inc/require.php';

use inc\db\QuarantaenieDB;

function validateDates($date1, $date2)
{
    if ($date1 > $date2)
    {
        $backlink = $_SESSION['backlink'] ?? '/index.php';
        header("HTTP/1.1 303 See Other");
        header("Location: $backlink");
        exit();
    }
}

checkSession('/actions/quarantine.php');

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
    $student_fk = $_POST['student_fk'] ?? null;
    $qStart = $_POST['qStart'] ?? null;
    $qEnd = $_POST['qEnd'] ?? null;
    if ($student_fk and $qStart and $qEnd)
    {
        validateDates($qStart, $qEnd);
        $db->insertQuarantine($qStart, $qEnd, $student_fk);
    }
}
elseif ($action == 'edit')
{
    $id = $_GET['qtID'] ?? null;
    $student_fk = $_POST['student_fk'] ?? null;
    $qStart = $_POST['qStart'] ?? null;
    $qEnd = $_POST['qEnd'] ?? null;

    if ($id and $student_fk and $qStart and $qEnd)
    {
        validateDates($qStart, $qEnd);
        $db->updateQuarantineById($id, $qStart, $qEnd, $student_fk);
    }
}
elseif ($action == 'delete') {
    $id = $_GET['qtID'] ?? null;

    if ($id)
    {
        $db->deleteQuarantineById($id);
    }
}

$backlink = $_SESSION['backlink'] ?? '/index.php';
header("HTTP/1.1 303 See Other");
header("Location: $backlink");
exit();