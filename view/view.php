<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/login.php');

if (!isset($_GET['user'])) {
    header("location: /view");
}
?>

<html>
    <head>
        <title>View scores</title>
        <?php
        require_once($_SERVER["DOCUMENT_ROOT"] . "/include/include_head.php");
        ?> 
    </head>
    <body>
       <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
        require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

        $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die(mysqli_error());
        
        $id = $_GET['user'];
        
        $sql = "SELECT * FROM scores WHERE userId=?";
        
        if ($_GET['sort'] == "name") {
            $sql .= " ORDER BY name";
        }
        elseif ($_GET['sort'] == "artist") {
            $sql .= " ORDER BY artist";
        }
        elseif ($_GET['sort'] == "speed") {
            $sql .= " ORDER BY speed DESC";
        }
        elseif ($_GET['sort'] == "score") {
            $sql .= " ORDER BY score DESC";
        }
        else {
            $sql .= " ORDER BY artist";
        }
        
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->free_result();
            $stmt->close();
        }
        
        echo "<p>Total fc's: " . $result->num_rows . "</p><form action='index.php' method='POST'>
        <table>
        <th><a href='view.php?sort=name&user=" . $id . "'>Name</a></th>
        <th><a href='view.php?sort=artist&user=" . $id . "'>Artist</a></th>
        <th><a href='view.php?sort=speed&user=" . $id . "'>Speed<a></th>
        <th><a href='view.php?sort=score&user=" . $id . "'>Score</a></th>
        <th><a href='view.php?sort=fc&user=" . $id . "'>FC?</a></th>";
    
        $i = 0;
    
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
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