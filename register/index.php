<?php
require_once(__DIR__ . '/../include/Login.php');
require_once(__DIR__ . '/../include/Head.php');
require_once(__DIR__ . '/../include/Header.php');
require_once(__DIR__ . '/../include/Database.php');


$Header = new Header();
$Head = new Head();
$Login = new Login();
$Database = new Database();

if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    $Database->createUser($_POST['username'], $_POST['password'], $_POST['email']);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
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
    .login-form input[type="text"],
    .login-form input[type="email"] {
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
      <h1>Register</h1>
      <form action="index.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="email" name="email" placeholder="Email address">
        <input type="password" name="password" placeholder="Password">
        <input type="submit">
      </form>
    </div>
  </body>
</html>