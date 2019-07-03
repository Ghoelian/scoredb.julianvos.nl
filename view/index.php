<?php
require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Head.php');
require_once(__DIR__ . '/../include/Database.php');

$Head = new Head();
$Header = new Header();
$Login = new Login();
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
        $Header->echoHeader();

        $result = $Database->getUsers();
        
        echo "<p>Select user:</p><table>";
        
        $i = 0;
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $username = $row["username"];
            
            if ($i % 2 == 0) {
                echo
                "<tr style='background-color: rgb(50, 50, 50)'>";
            } else {
                echo "<tr style='background-color: rgb(36, 36, 36)'>";
            }

            echo 
            "<td><a href='view.php?user=" . $username . "'>" . $username . "</a></td>
            </tr>";
            
            $i++;
        }
        
        $con->close();
        ?>
    </body>
</html>