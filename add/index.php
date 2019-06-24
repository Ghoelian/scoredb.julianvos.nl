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

if ($Login->check($_COOKIE['username'], $_COOKIE['token'])) {
    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $artist = $_POST["artist"];
        $speed = $_POST["speed"];
        $score = $_POST["score"];
        $userId = $Database->getId($_COOKIE['username']);

        if (isset($_POST["fc"])) {
            $fc = 1;
        } else {
            $fc = 0;
        }

        echo $Database->addScore($name, $artist, $speed, $score, $userId, $fc);
    }
} else {
    echo "Please log in first";
}
?>

<html>
    <head>
        <title>Add score</title>
        <?php
    $Head->echoHead();
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
        $Header->echoHeader();
        ?>
        
        <div class="login-form">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Song:</td>
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

