<?php
header("location: /index.php");

require_once($_SERVER['DOCUMENT_ROOT'] . '/include/login.php');
?>

<html>
    <head>
        <title>Edit scores</title>
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
            if(checkLogin($_COOKIE['token'], $_COOKIE['username'])) { ?>
            <button type="button" disabled>Logged in as <?php echo get('name'); ?></button>
            <?php 
            } ?>
            <a href="/index.php"><button type="button">Home</button></a>
            <a href="/add"><button type='button'>Add</button></a>
            <!--<button type='button'>Edit</button>-->
            <a href="/view"><button type='button'>View</button></a>
            <?php
            if(checkLogin($_COOKIE['token'], $_COOKIE['username'])) {
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
if(checkLogin($_COOKIE['token'], $_COOKIE['username'])) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die(mysqli_error());
    
    if($stmt = $con->prepare("SELECT * FROM `scores` WHERE `userId` = ?")) {
        $stmt->bind_param("i", get('id'));
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->free_result();
        $stmt->close();
    }
    
    if(isset($_POST["submit"])) {
        
    }

    echo "<p>Total fc's: " . $result->num_rows . "</p><form action='index.php' method='POST'>
    <table>
    <tr><td><input type='submit'></td></tr>
    <th><a href='index.php?sort=name'>Name</a></th>
    <th><a href='index.php?sort=artist'>Artist</a></th>
    <th><a href='index.php?sort=speed'>Speed<a></th>
    <th><a href='index.php?sort=score'>Score</a></th>
    <th><a href='index.php?sort=fc'>FC?</a></th>";
    
    $i = 0;
    
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        /*  
        0 = id
        1 = userId
        2 = name
        3 = artist
        4 = speed
        5 = score
        6 = fc
        7 = image
        */
        
        $name = $row[2];
        $artist = $row[3];
        $speed = $row[4];
        $score = $row[5];
        $fc = $row[7];
        $image = $row[6];
        
        if($fc == 0) {
        if($i % 2 == 0) {
            echo "<tr style='background-color: rgb(50, 50, 50)'>
            <td><input type='text' id='name' name='name' value='" . $name . "'></td>
            <td><input type='text' id='artist' name='artist' value='" . $artist . "'></td>
            <td><input type='number' min='1' name='speed' id='speed' value='" . $speed . "'></td>
            <td class='score'><input type='number' min='1' name='score' id='score' value='" . $score . "'></td>
            <td><input type='checkbox' name='fc' id='fc'></td></tr>";
        } else {
            echo "<tr style='background-color: rgb(36, 36, 36)'>
            <td><input type='text' id='name' name='name' value='" . $name . "'></td>
            <td><input type='text' id='artist' name='artist' value='" . $artist . "'></td>
            <td><input type='number' min='1' name='speed' id='speed' value='" . $speed . "'></td>
            <td class='score'><input type='number' min='1' name='score' id='score' value='" . $score . "'></td>
            <td><input type='checkbox' name='fc' id='fc'></td></tr>";
        }
        } else {
            if($i % 2 == 0) {
            echo "<tr style='background-color: rgb(50, 50, 50)'>
            <td><input type='text' id='name' name='name' value='" . $name . "'></td>
            <td><input type='text' id='artist' name='artist' value='" . $artist . "'></td>
            <td><input type='number' min='1' name='speed' id='speed' value='" . $speed . "'></td>
            <td class='score'><input type='number' min='1' name='score' id='score' value='" . $score . "'></td>
            <td><input type='checkbox' name='fc' checked id='fc'></td></tr>";
        } else {
            echo "<tr style='background-color: rgb(36, 36, 36)'>
            <td><input type='text' id='name' name='name' value='" . $name . "'></td>
            <td><input type='text' id='artist' name='artist' value='" . $artist . "'></td>
            <td><input type='number' min='1' name='speed' id='speed' value='" . $speed . "'></td>
            <td class='score'><input type='number' min='1' name='score' id='score' value='" . $score . "'></td>
            <td><input type='checkbox' name='fc' checked id='fc'></td></tr>";
        }
        }
        
        $i++;
    }
    
    echo "<tr><td><input type='submit' name='submit' id='submit'></td></tr></table></form>";
    
    $con->close();
} else {
    echo "<p>Please log in</p>";
}
?>
</body>
</html>