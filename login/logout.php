<?php
require_once(__DIR__ . '/../include/Login.php');
$Login = new Login();

$Login->log_out();
header('Location: index.php');
?>
