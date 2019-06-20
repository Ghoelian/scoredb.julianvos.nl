<?php
class Login
{
    private $con;
    private $Database;

    public function __construct()
    {
        require_once(__DIR__ . '/../config/Config.php');
        require_once(__DIR__ . '/Database.php');

        $this->Database = new Database();
        $this->config = new Config();

        $this->con = mysqli_connect($this->config->getHost(), $this->config->getUser(), $this->config->getPass(), $this->config->getName());
        if (mysqli_connect_errno()) {
            die('Failed to connect: ' . mysqli_connect_error());
        }
    }

    public function log_in($username, $password)
    {
        if ($stmt = $this->con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $passwordDB);
                $stmt->fetch();
        
                if (password_verify($password, $passwordDB)) {
                    $token = hash('sha256', uniqid('', true));
                    setcookie('token', $token, time()+60*60*24*30, '/', 'localhost', false, true);
                    setcookie('username', $username, time()+60*60*24*30, '/', 'localhost', false, true);

                    if ($this->Database->putToken($token, $username)) {
                        header('location: /index.php');
                    } else {
                        echo '<p>Failed to put token in ' . __FILE__ . ":" . __LINE__ . "</p>";
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
            echo '<p>Could not prepare statement in ' . __FILE__ . ":" . __LINE__ . "</p>";
            $this->log_out();
        }
    }

    public function check()
    {
    }

    public function log_out()
    {
        setcookie('token', time() - 3600);
        setcookie('username', time() - 3600);
        $this->Database->deleteToken();
    }
}
