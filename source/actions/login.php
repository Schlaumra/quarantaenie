<?php

require_once '../inc/require.php';

use inc\user\User;

if (!is_file(User::$location))
{
    $userFile = new User('admin', 'Kennwort0!');
    $userFile->save();
}
else
{
    session_start();
    $userFile = new User('admin');
    $admin = $userFile->load();

    if ($_POST['username'] == $admin['username'] and password_verify($_POST['password'], $admin['password_hash']))
    {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['failedLogin'] = false;
        $redirectTarget = $_SESSION['redirectTarget'] ?? 'index.php';
    }
    else
    {
        $_SESSION['failedLogin'] = true;
        $redirectTarget = 'login.php';
    }
    header("HTTP/1.1 303 See Other");
    header("Location: ../$redirectTarget");
    exit();
}