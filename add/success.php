<?php
require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Head.php');
require_once(__DIR__ . '/../config/Config.php');
require_once(__DIR__ . '/../include/Database.php');

$Head = new Head();
$Header = new Header();
?>

<html>

<head>
	<title>Score inserted</title>
	<?php
	$Head->echoHead();
	?>
</head>

<body>
	<?php
	$Header->echoHeader();
	?>

	<h1>Score inserted!</h1>
</body>

</html>