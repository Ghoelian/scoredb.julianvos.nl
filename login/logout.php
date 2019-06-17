<?php
require_once('/include/Login.php');
$Login = new Login();

$Login->log_out();
header('Location: index.php');
?>