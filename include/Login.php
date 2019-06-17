<?php
class Login
{
    private $con;
    private $Database;

    public function Login()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/config/Config.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/include/Database.php');

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
                    setcookie('token', $token, time()+60*60*24*30, '/', 'scoredb.julianvos.nl', false, true);
                    setcookie('username', $username, time()+60*60*24*30, '/', 'scoredb.julianvos.nl', false, true);

                    if ($this->Database->insert('token', $token)) {
                        header('location: /index.php');
                    } else {
                        echo 'Failed to put token, please try again later<br/>';
                        $this->log_out();
                    }
                } else {
                    echo 'Incorrect username/password<br/>';
                    $this->log_out();
                }
            } else {
                echo 'Incorrect username/password<br/>';
                $this->log_out();
            }
            $stmt->close();
        } else {
            echo 'Could not prepare statement<br/>';
            $this->log_out();
        }
    }

    public function check()
    {
    }

    public function log_out()
    {
    }
}
