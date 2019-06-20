<?php
require_once(__DIR__ . '/include/Login.php');
require_once(__DIR__ . '/include/Header.php');
require_once(__DIR__ . '/include/Head.php');
require_once(__DIR__ . '/include/Database.php');

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
    if (isset($_COOKIE['username']) && isset($_COOKIE['token'])) {
        if ($Login->check($_COOKIE['username'], $_COOKIE['token'])) {
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
