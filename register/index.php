<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/login.php');

if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    createUser($_POST['username'], $_POST['password'], $_POST['email']);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . '/include/include_head.php');
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