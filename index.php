<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/login.php');
?>

<html>
    <head>
        <title>Score database</title>
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/include/include_head.php");
    ?>
    </head>
    <body>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');

if($loggedin) {
    echo "<p>You are logged in as " . get(name) . "</p><br>";
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