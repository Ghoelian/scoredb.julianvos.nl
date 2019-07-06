<?php
require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Head.php');
require_once(__DIR__ . '/../config/Config.php');
require_once(__DIR__ . '/../include/Database.php');

$Database = new Database();
$Head = new Head();
$Header = new Header();
$Login = new Login();
$Config = new Config();

if (!isset($_GET['user'])) {
    header("location: /view");
}
?>

<html>
    <head>
        <title>View scores</title>
        <?php
        $Head->echoHead();
        ?> 
    </head>
    <body>
       <?php
        $Header->echoHeader();

        $name = $_GET['user'];

        $images = $Database->getImages($name, $_GET['sort']);
        
        echo "<p>Total scores: " . $images->num_rows . "</p><br>
        <form action='index.php' method='POST'>
        <table>
        <th><a href='view.php?sort=name&user=" . $name . "'>Name</a></th>
        <th><a href='view.php?sort=artist&user=" . $name . "'>Artist</a></th>
        <th><a href='view.php?sort=speed&user=" . $name . "'>Speed<a></th>
        <th><a href='view.php?sort=score&user=" . $name . "'>Score</a></th>
        <th><a href='view.php?sort=fc&user=" . $name . "'>FC?</a></th>";
    
        $i = 0;
    
        while ($row = $images->fetch_array(MYSQLI_ASSOC)) {
            $name = $row["name"];
            $artist = $row["artist"];
            $speed = $row["speed"];
            $score = $row["score"];
            $image = $row["image"];
            $fc = $row["fc"];

            if ($i % 2 == 0) {
                echo '<tr style="background-color: rgb(50, 50, 50)">';
            } else {
                echo '<tr style="background-color: rgb(36, 36, 36)">';
            }

            echo '<td> <a href="' . $image . '">' . $name . '</a></td>
                <td>' . $artist . '</td>
                <td>' . $speed . '</td>
                <td class="score">' . $score . '</td>';
                
            if ($fc == 0) {
                echo '<td><input type="checkbox" disabled></td></tr>';
            } else {
                echo '<td><input type="checkbox" checked disabled></td></tr>';
            }
            $i++;
        }
        
        $con->close();
        ?>
    </body>
</html>