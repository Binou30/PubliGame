<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

session_destroy();

header('Location: index.php');
exit;
?>
