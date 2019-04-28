<?php
session_start();
if (!isset($_GET['user'])) {
    header("location: /view");
}
?>

<html>
    <head>
        <title>View scores</title>
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
            if($_SESSION['loggedin']) { ?>
            <button type="button" disabled>Logged in as <?php echo $_SESSION['name'] ?></button>
            <?php 
            } ?>
            <a href="/index.php"><button type="button">Home</button></a>
            <a href="/add"><button type='button'>Add</button></a>
            <!--<button type='button'>Edit</button>-->
            <a href="/view"><button type='button'>View</button></a>
            <?php
            if($_SESSION['loggedin']) {
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
                    echo $image;
                    echo "<tr style='background-color: rgb(50, 50, 50)'>
                    <td> <a href='" . $image . "'>" . $name . "</a></td>
                    <td>" . $artist . "</td>
                    <td>" . $speed . "</td>
                    <td class='score'>" . $score . "</td>
                    <td><input type='checkbox' disabled></td></tr>";
                } else {
                    echo "<tr style='background-color: rgb(36, 36, 36)'>
                    <td> <a href='" . $image . "'>" . $name . "</a></td>
                    <td>" . $artist . "</td>
                    <td>" . $speed . "</td>
                    <td class='score'>" . $score . "</td>
                    <td><input type='checkbox' disabled></td></tr>";
                }
            } else {
                if ($i % 2 == 0) {
                    echo "<tr style='background-color: rgb(50, 50, 50)'>
                    <td> <a href='" . $image . "'>" . $name . "</a></td>
                    <td>" . $artist . "</td>
                    <td>" . $speed . "</td>
                    <td class='score'>" . $score . "</td>
                    <td><input type='checkbox' checked disabled></td></tr>";
                } else {
                    echo "<tr style='background-color: rgb(36, 36, 36)'>
                    <td> <a href='" . $image . "'>" . $name . "</a></td>
                    <td>" . $artist . "</td>
                    <td>" . $speed . "</td>
                    <td class='score'>" . $score . "</td>
                    <td><input type='checkbox' checked disabled></td></tr>";
                }
            }
            $i++;
        }
        
        $con->close();
        ?>
    </body>
</html>