<?php
// require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Head.php');
require_once(__DIR__ . '/../include/Database.php');

$Head = new Head();
// $Header = new Header();
// $Login = new Login();
$Database = new Database();
?>

<html>
    <head>
        <title>View user scores</title>
        <?php
        $Head->echoHead();
        ?>
    </head>
    
    <body>
        <?php
        // $Header->echoHeader();

        $result = $Database->getUsers();
        
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