<html>
<head>
    <title>Show Image</title>
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/include/include_head.php");
    ?>
</head>

<body>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');

$image = $_GET["image"];
echo "<img src='" . $image . "'>";
?>
</body>
</html>