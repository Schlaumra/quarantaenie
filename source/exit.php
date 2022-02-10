<?php
session_start();
session_destroy();

header("HTTP/1.1 303 See Other");
header("Location: /index.php");
exit();