<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/login.php');

if (checkLogin($_COOKIE['token'], $_COOKIE['username'])) {
if (isset($_POST["submit"])) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die(mysqli_error());
    
    $name = $_POST["name"];
    $artist = $_POST["artist"];
    $speed = $_POST["speed"];
    $score = $_POST["score"];
    $userId = get('id');
    
    if(isset($_POST["fc"])) {
        $fc = 1;
    } else {
        $fc = 0;
    }
    
    $path_parts = pathinfo($_FILES["image"]["name"]);
    $imageFileType = $path_parts['extension'];
    
    $target_dir = "/images/" . $userId;
    $target_file = $target_dir . "/" . md5(uniqid()) . ".png";
    $imageUploaded = 0;
    
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $target_dir)) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . $target_dir, 0777, true);
    }
    
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $target_file)) {
        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                if ($stmt = $con->prepare("INSERT INTO `scores` (`userId`, `name`, `artist`, `speed`, `score`, `fc`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
                $stmt->bind_param("issiiis", $userId, $name, $artist, $speed, $score, $fc, $target_file);
                $stmt->execute();
                $stmt->close();
                echo "<h2>Score inserted</h2>";
            } else {
                echo "<h2>Prepare statement failed</h2>";
            }
            } else {
                echo "<h2>File upload failed</h2>";
            }
        } else {
            echo "<h2>Wrong file type</h2>";
        }
    } else {
        echo "<h2>File exists</h2>";
    }
    $con->close();
}
} else {
    echo "Please log in first";
}
?>

<html>
    <head>
        <title>Add score</title>
        <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/include_head.php");
    ?>
        <style>
    .login-form {
      width: 300px;
      margin: 0 auto;
      font-family: Tahoma, Geneva, sans-serif;
    }
    .login-form h1 {
      text-align: center;
      color: #4d4d4d;
      font-size: 24px;
      padding: 20px 0 20px 0;
    }
    .login-form input[type="password"],
    .login-form input[type="number"],
    .login-form input[type="text"] {
      width: 100%;
      padding: 15px;
      border: 1px solid #dddddd;
      margin-bottom: 15px;
      box-sizing:border-box;
    }
    .login-form input[type="submit"] {
      width: 100%;
      padding: 15px;
      background-color: #535b63;
      border: 0;
      box-sizing: border-box;
      cursor: pointer;
      font-weight: bold;
      color: #ffffff;
    }
    </style>
    </head>
    <body>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
        ?>
        
        <div class="login-form">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="name" id="name"></td>
                </tr>
                <tr>
                    <td>Artist:</td>
                    <td><input type="text" name="artist" id="artist"></td>
                </tr>
                <tr>
                    <td>Speed:</td>
                    <td><input type="number" name="speed" id="speed" min="1"></td>
                </tr>
                <tr>
                    <td>Score:</td>
                    <td><input type="number" name="score" id="score" min="1"></td>
                </tr>
                <tr>
                    <td>FC?</td>
                    <td><input type="checkbox" name="fc" id="fc" value="yes"></td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><input type="file" name="image" id="image"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit"></td>
                </tr>
            </table>
            </div>
        </form>
    </body>
</html>

