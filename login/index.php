<?php
if (isset($_POST['username'], $_POST['password'])) {
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect: ' . mysqli_connect_error());
    }

    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
        
            if (password_verify($_POST['password'], $password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('location: /index.php');
            } else {
                echo 'Incorrect username/password';
            }
        } else {
            echo 'Incorrect username/password';
        }
        $stmt->close();
    } else {
        echo 'Could not prepare statement';
    }
}

$con->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Log in</title>
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
        
    <div class="login-form">
      <h1>Log in</h1>
      <form action="index.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit">
      </form>
    </div>
  </body>
</html>