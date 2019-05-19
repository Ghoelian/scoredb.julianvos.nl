<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

function login($username, $password) {
    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect: ' . mysqli_connect_error());
    }

    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $passwordDB);
            $stmt->fetch();
        
            if (password_verify($password, $passwordDB)) {
                $token = hash('sha256', uniqid('', true));
                setcookie('token', $token, time()+60*60*24*30, '/', 'scoredb.julianvos.nl', false, true);
                setcookie('username', $username, time()+60*60*24*30, '/', 'scoredb.julianvos.nl', false, true);

                putToken($token);
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

function checkLogin($token, $username) {
}

function logout() {
}

function get($column) {
}

function createUser($username, $password, $email) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect: ' . mysqli_connect_error());
    }

    if ($stmt = $con->prepare('INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)')) {
        $stmt->bind_param('sss', $username, $email, password_hash($password, PASSWORD_DEFAULT));
        $stmt->execute();
        
        echo "New user created";
    } else {
        echo 'Could not prepare statement';
    }
}
