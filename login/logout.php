<?php
require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Head.php');

$Head = new Head();
$Header = new Header();
$Login = new Login();
?>

<html>

<head>
    <title>Score database</title>
    <?php
        $Head->echoHead();
    ?>
</head>

<body>
    <?php
$Header->echoHeader();

$Login->log_out();
?>

</body>
</html>