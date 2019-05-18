<html>
<head>
    <title>Show Image</title>
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/include_head.php");
    ?>
</head>

<body>
    <div class='header' style='width: 100%; height: 5%; background-color: rgb(50, 50, 50)'>
            <style>
            button {
            width: 19%;
            padding: 15px;
            background-color: #535b63;
            border: 0;
            box-sizing: border-box;
            cursor: pointer;
            font-weight: bold;
            color: #ffffff;
            }
            </style>
            <?php
            if ($loggedin) {
                ?>
            <button type="button" disabled>Logged in as <?php echo setcookie('name'] ?></button>
            <?php
            } ?>
            <a href="/index.php"><button type="button">Home</button></a>
            <a href="/add"><button type='button'>Add</button></a>
            <!--<button type='button'>Edit</button>-->
            <a href="/view"><button type='button'>View</button></a>
            <?php
            if ($loggedin) {
                ?>
            <a href="/login/logout.php"><button type='button'>Log out</button></a>
            <?php
            } else {
                ?>
                <a href="/login"><button type='button'>Log in</button></a>
                <a href="/register"><button type="button">Sign up</button></a>
                <?php
            }
            ?>
        </div>

<?php
$image = $_GET["image"];
echo "<img src='" . $image . "'>";
?>
</body>
</html>