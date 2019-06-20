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

        $id = $_GET['user'];

        $images = $Database->getImages($id, $_GET['sort']);
        
        echo "<p>Total fc's: " . $images->num_rows . "</p><form action='index.php' method='POST'>
        <table>
        <th><a href='view.php?sort=name&user=" . $id . "'>Name</a></th>
        <th><a href='view.php?sort=artist&user=" . $id . "'>Artist</a></th>
        <th><a href='view.php?sort=speed&user=" . $id . "'>Speed<a></th>
        <th><a href='view.php?sort=score&user=" . $id . "'>Score</a></th>
        <th><a href='view.php?sort=fc&user=" . $id . "'>FC?</a></th>";
    
        $i = 0;
    
        while ($row = $images->fetch_array(MYSQLI_NUM)) {
            $name = $row[2];
            $artist = $row[3];
            $speed = $row[4];
            $score = $row[5];
            $fc = $row[7];
            $image = $row[6];

            if ($fc == 0) {
                if ($i % 2 == 0) {
                    echo '<tr style="background-color: rgb(50, 50, 50)">
                    <td> <a href="' . $image . '">' . $name . '</a></td>
                    <td>' . $artist . '</td>
                    <td>' . $speed . '</td>
                    <td class="score">' . $score . '</td>
                    <td><input type="checkbox" disabled></td></tr>';
                } else {
                    echo '<tr style="background-color: rgb(36, 36, 36)">
                    <td> <a href="' . $image . '">' . $name . '</a></td>
                    <td>' . $artist . '</td>
                    <td>' . $speed . '</td>
                    <td class="score">' . $score . '</td>
                    <td><input type="checkbox" disabled></td></tr>';
                }
            } else {
                if ($i % 2 == 0) {
                    echo '<tr style="background-color: rgb(50, 50, 50)">
                    <td> <a href="' . $image . '">' . $name . '</a></td>
                    <td>' . $artist . '</td>
                    <td>' . $speed . '</td>
                    <td class="score">' . $score . '</td>
                    <td><input type="checkbox" checked disabled></td></tr>';
                } else {
                    echo '<tr style="background-color: rgb(36, 36, 36)">
                    <td> <a href="' . $image . '">' . $name . '</a></td>
                    <td>' . $artist . '</td>
                    <td>' . $speed . '</td>
                    <td class="score">' . $score . '</td>
                    <td><input type="checkbox" checked disabled></td></tr>';
                }
            }
            $i++;
        }
        
        $con->close();
        ?>
    </body>
</html>