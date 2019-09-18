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

if (isset($_COOKIE['username']) && isset($_COOKIE['token']) && $Login->check($_COOKIE['username'], $_COOKIE['token'])) {
    if (isset($_POST["submit"])) {
        $userId = $Database->getId($_COOKIE['username']);

        echo $Database->addScore($name, $artist, $speed, $score, $userId, $fc);
    }
} else {
    header('Location: ../login/index.php');
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

