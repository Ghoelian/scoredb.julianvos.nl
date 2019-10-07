<?php
class Header
{
    private $Login;

    public function __construct()
    {
        $this->Login = new Login();
    }

    public function echoHeader()
    {
        echo "<style> 
        .header {
            width: 19%;
            height: 99%;
            background-color: #535b63;
            text-align: center;
            font-weight: bold;
            color: #ffffff;
          }
        
          .container {
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-items: stretch;
          }
        </style>";

        echo "<div class='container' style='width: 100%; height: 5%; background-color: rgb(50, 50, 50)'>";

        if (isset($_COOKIE['token']) && isset($_COOKIE['username'])) {
            if ($this->Login->check($_COOKIE['username'], $_COOKIE['token'])) {
                echo "<a class='header' >Logged in as ";
                echo $_COOKIE['username'];
                echo "</a>";
            }
        }
        echo "<a class='header' href='/index.php'>Home</a>
            <a class='header' href='/add'>Add</a>
            <a class='header' href='/view'>View</a>";
        if (isset($_COOKIE['token']) && isset($_COOKIE['username'])) {
            if ($this->Login->check($_COOKIE['username'], $_COOKIE['token'])) {
                echo "<a class='header' href='/login/logout.php'>Log out</a>";
            } else {
                echo "<a class='header' href='/login'>Log in</a>
                    <a class='header' href='/register'>Sign up</a>";
            }
        } else {
            echo "<a class='header' href='/login'>Log in</a>
                <a class='header' href='/register'>Sign up</a>";
        }
        echo "</div><br>";
    }
}
