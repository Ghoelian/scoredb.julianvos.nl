<?php
class Login
{
    private $con;
    private $Database;
    private $Config;

    public function __construct()
    {
        require_once(__DIR__ . '/../config/Config.php');
        require_once(__DIR__ . '/Database.php');

        $this->Config = new Config();

        $this->con = mysqli_connect($this->Config->getHost(), $this->Config->getUser(), $this->Config->getPass(), $this->Config->getName());
        if (mysqli_connect_errno()) {
            die('Could not connect to the database. Please try again later!');
        }
    }

    public function load() {
        $this->Database = new Database();
    }

    public function log_in($username, $password)
    {
        $this->load();
        if ($stmt = $this->con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $passwordDB);
                $stmt->fetch();
        
                if (password_verify($password, $passwordDB)) {
                    $token = uniqid('', true);
                    $hashToken = password_hash($token, PASSWORD_BCRYPT);

                    setcookie('token', $token, time()+60*60*24*30, '/', 'localhost', false, true);
                    setcookie('username', $username, time()+60*60*24*30, '/', 'localhost', false, true);

                    echo $username . $token;

                    if ($this->Database->putToken($hashToken, $username)) {
                        header('location: /index.php');
                    } else {
                        echo '<p>Failed to put login token in database. Please try again later!<p>';
                        $this->log_out();
                    }
                } else {
                    echo '<p>Incorrect username/password</p>';
                    $this->log_out();
                }
            } else {
                echo '<p>Incorrect username/password</p>';
                $this->log_out();
            }
            $stmt->close();
        } else {
            echo '<p>Could not log in. Please try again later!</p>';
            $this->log_out();
        }
    }

    public function check($username, $token)
    {
        if ($stmt = $this->con->prepare('SELECT token FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($tokenDB);
                $stmt->fetch();
        
                if (password_verify($token, $tokenDB)) {
                    return true;
                } else {
                    echo '<p>Could not verify user. You will be logged out in 5 seconds.';
                    sleep(5);
                    $this->log_out();
                    return false;
                }
            } else {
                echo '<p>Could not verify user. You will be logged out in 5 seconds.';
                sleep(5);
                $this->log_out();
                return false;
            }
            $stmt->close();
        } else {
            echo '<p>Could not verify user. You will be logged out in 5 seconds.';
            sleep(5);
            $this->log_out();
            return false;
        }
    }

    public function log_out()
    {
        $this->load();
        setcookie('token', '', time() - 3600);
        setcookie('username', '', time() - 3600);
        $this->Database->deleteToken($_COOKIE['username']);
        header('location: /index.php');
    }
}
