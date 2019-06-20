<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/login.php');
?>

<html>
    <head>
        <title>View user scores</title>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/include/include_head.php");
        ?>
    </head>
    
    <body>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

        $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die(mysqli_error());
        
        if($stmt = $con->prepare("SELECT id, username FROM `accounts`")) {
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->free_result();
            $stmt->close();
        }
        
        echo "<p>Select user:</p><table>";
        
        $i = 0;
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $username = $row[1];
            $id = $row[0];
            
            if ($i % 2 == 0) {
                echo "<tr style='background-color: rgb(50, 50, 50)'><td><a href='view.php?user=" . $id . "'>" . $username . "</a></td></tr>";
            } else {
                echo "<tr style='background-color: rgb(36, 36, 36)'><td><a href='view.php?user=" . $id . "'>" . $username . "</a></td></tr>";
            }
            
            $i++;
        }
        
        $con->close();
        ?>
    </body>
</html>