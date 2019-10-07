<?php
require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Head.php');

$Head = new Head();
$Header = new Header();
$Login = new Login();

if (!isset($_GET['image'])) {
	header("Location: /view");
}
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
	?>

	<img width='100%' src=' <?php
	echo $_GET['image']
	?>'>
</body>

</html>