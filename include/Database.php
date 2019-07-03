<?php
class Database
{
    private $con;
    private $Config;
    private $Login;

    public function __construct()
    {
        require_once(__DIR__ . '/../config/Config.php');
        require_once(__DIR__ . '/../include/Login.php');

        $this->Config = new Config();
        $this->con = mysqli_connect($this->Config->getHost(), $this->Config->getUser(), $this->Config->getPass(), $this->Config->getName());

        if (mysqli_connect_errno()) {
            die('Could not connect to the database. Please try again later!');
        }
    }

    public function load()
    {
        $this->Login = new Login();
    }

    public function getId($username)
    {
        $this->load();
        if ($stmt = $this->con->prepare('SELECT id FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id);
                $stmt->fetch();

                return $id;
            } else {
                echo '<p>Could not get user id. Please try again later!</p>';
                $this->Login->log_out();
            }
            $stmt->close();
        } else {
            echo '<p>Could not get user id. Please try again later!</p>';
            $this->Login->log_out();
        }
    }

    public function deleteToken($username)
    {
        if ($stmt = $this->con->prepare('UPDATE accounts SET token = null WHERE username = ?')) {
            if ($stmt->bind_param('s', $username)) {
                if ($stmt->execute()) {
                    return true;
                } else {
                    echo 'Something went wrong. Please try again later!';
                    return false;
                }
            } else {
                echo 'Something went wrong. Please try again later!';
                return false;
            }
        } else {
            echo 'Something went wrong. Please try again later!';
        }
    }

    public function putToken($token, $username)
    {
        $this->load();
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
            echo '<p>Could not log in. Please try again later!</p>';
            $this->Login->log_out();
        }
    }

    public function createUser($username, $password, $email)
    {
        if ($stmt = $this->con->prepare('INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)')) {
            $stmt->bind_param('sss', $username, $email, password_hash($password, PASSWORD_BCRYPT));
            $stmt->execute();
        
            echo '<p>New user created</p>';
        } else {
            echo '<p>Could not create user</p><br>';
        }
    }

    public function getImages($name, $sort)
    {
        $sql = "SELECT name, artist, speed, score, image, fc 
                FROM accounts 
                JOIN scores 
                    on accounts.id = scores.userId 
                WHERE accounts.username = ?";

        if (isset($sort)) {
            $sql .= " ORDER BY " . $sort;
        } else {
            $sql .= " ORDER BY artist";
        }
        
        if ($stmt = $this->con->prepare($sql)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->free_result();
            $stmt->close();
        } else {
            echo "<h2>Getting scores failed. Please try again later!</h2>";
        }
        
        return $result;
    }

    public function getUsers()
    {
        if ($stmt = $this->con->prepare("SELECT username FROM `accounts`")) {
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->free_result();
            $stmt->close();
        } else {
            echo "<h2>Getting users failed. Please try again later!</h2>";
        }

        return $result;
    }

    public function addScore($name, $artist, $speed, $score, $userId, $fc)
    {
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $imageFileType = $path_parts['extension'];
    
        $target_dir = "/images/" . $userId;
        $target_file = $target_dir . "/" . md5(uniqid()) . ".png";
        $imageUploaded = 0;
    
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $target_dir)) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . $target_dir, 0777, true);
        }
    
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                    $sql = "INSERT INTO `scores`
                    (`userId`, `name`, `artist`, `speed`, `score`, `fc`, `image`)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                    if ($stmt = $this->con->prepare($sql)) {
                        if ($stmt->bind_param("issiiis", $userId, $name, $artist, $speed, $score, $fc, $target_file)) {
                            if ($stmt->execute()) {
                                $stmt->close();
                                return "<h2>Score inserted!</h2>";
                            } else {
                                return "<h2>Adding score failed. Please try again later!</h2>";
                            }
                        } else {
                            return "<h2>Adding score failed. Please try again later!</h2>";
                        }
                    } else {
                        return "<h2>Adding score failed. Please try again later!</h2>";
                    }
                } else {
                    return "<h2>Adding score failed. Please try again later!</h2>";
                }
            } else {
                return "<h2>Wrong file type.</h2>";
            }
        } else {
            return "<h2>Adding score failed. Please try again!</h2>";
        }
    }
}
