<?php

?>

<html>
    <head>
        <title>View user scores</title>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . "/include/include_head.php");
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
            if(setcookie('loggedin']) { ?>
            <button type="button" disabled>Logged in as <?php echo setcookie('name'] ?></button>
            <?php 
            } ?>
            <a href="/index.php"><button type="button">Home</button></a>
            <a href="/add"><button type='button'>Add</button></a>
            <!--<button type='button'>Edit</button>-->
            <a href="/view"><button type='button'>View</button></a>
            <?php
            if(setcookie('loggedin']) {
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