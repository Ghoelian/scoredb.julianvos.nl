<?php
class Database
{
    var $con;

    public function Database()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/config/Config.php');
        $Config = new Config();

        $this->con = mysqli_connect($Config->getHost(), $Config->getUser(), $Config->getPass(), $Config->getName());

        if (mysqli_connect_errno()) {
            die('Failed to connect: ' . mysqli_connect_error());
        }
    }

    public function get($column)
    {
    }

    public function insert($column, $data)
    {
        if ($stmt = $this->con->prepare('INSERT INTO accounts (?) VALUES (?)')) {
            $stmt->bind_param('ss', $column, $data);
            $stmt->execute();
            return TRUE;
        } else {
            echo 'Could not prepare statement';
            return FALSE;
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
            echo 'Could not prepare statement';
        }
    }
}
