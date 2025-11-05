<?php
require_once 'lib/common.php';
session_start();

// Log out the user
logout();

// Redirect to home page
header('Location: index.html');
exit();
?>