<html>
<head>
    <title>Show Image</title>
    <?php
    require_once(__DIR__ . '/include/include_head.php');
    ?>
</head>

<body>
<?php
require_once(__DIR__ . '/include/header.php');

$image = $_GET['image'];
echo "<img src='" . $image . "'>";
?>
</body>
</html>