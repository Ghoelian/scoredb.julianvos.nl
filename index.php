<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/Login.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/Header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/Head.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/include/Database.php");

$Head = new Head();
$Header = new Header();
$Login = new Login();
$Database = new Database();
?>

<html>

<head>
    <title>Score database</title>
    <?php
        $Head->echoHead();
    ?>
</head>

<body>
    <?php
$Header->echoHeader();
    if ($Login->check()) {
        echo "<p>You are logged in as " . $Database->get("name") . "</p><br>";
        echo "<p><a href='/add'>Add an fc</a></p>";
        // echo "<p><a href='/edit'>Edit an fc</a></p>";
        echo "<p><a href='/view'>View a user's scores</a></p>";
        echo "<p><a href='/login/logout.php'>Log out</a></p>";
    } else {
        echo "
<html>
    <body>
        <p><a href='/login'>Log in</a></p>
        <p><a href='/register'>Sign up</a></p>
        <p><a href='/view'>View a user's scores</a></p>
    </body>
</html>
";
    }
?>
</body>

</html>
