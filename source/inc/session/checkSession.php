<?php

/**
 * Check if the user is logged in else redirect to login.php
 *
 * @param string $redirection => The page to redirect after login.
 * @return void
 */
function checkSession(string $redirection): void
{
    // Start client session
    session_start();

    if (!key_exists('username', $_SESSION))
    {
        // Redirect to log in
        $_SESSION['redirectTarget'] = $redirection;
        header("HTTP/1.1 303 See Other");
        header("Location: /login.php");
        exit();
    }
}