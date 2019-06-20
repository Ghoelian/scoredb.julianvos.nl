<?php
class Database
{
    public $con;

    public function __construct()
    {
        require_once(__DIR__ . '/../config/Config.php');
        $Config = new Config();

        $this->con = mysqli_connect($Config->getHost(), $Config->getUser(), $Config->getPass(), $Config->getName());

        if (mysqli_connect_errno()) {
            die('Failed to connect: ' . mysqli_connect_error());
        }
    }

    public function get($column)
    {
    }

    public function putToken($token, $username)
    {
        if ($stmt = $this->con->prepare('UPDATE accounts SET token = ? WHERE username = ?')) {
            if ($stmt->bind_param('ss', $token, $username)) {
                if ($stmt->execute()) {
                    return true;
                } else {
                    echo '<p>execute() failed: ' . $stmt->error . ' in ' . __FILE__ . ':' . __LINE__. '</p>';
                    return false;
                }
            } else {
                echo '<p>bind_param() failed: ' . $stmt->error . ' in ' . __FILE__ . ':' . __LINE__ . '</p>';
                return false;
            }
        } else {
            echo '<p> prepare() failed: ' . $this->con->error . ' in ' . __FILE__ . ':' . __LINE__ . '</p>';
        }
    }

    public function createUser($username, $password, $email)
    {
        if (mysqli_connect_errno()) {
            die('Failed to connect: ' . mysqli_connect_error());
        }

        if ($stmt = $this->con->prepare('INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)')) {
            $stmt->bind_param('sss', $username, $email, password_hash($password, PASSWORD_DEFAULT));
            $stmt->execute();
        
            echo 'New user created';
        } else {
            echo 'Could not prepare statement in ' . __FILE__ . ":" . __LINE__ . "</p><br>";
        }
    }
}
