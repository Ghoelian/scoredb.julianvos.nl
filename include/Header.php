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
        .button {
        		display: inline-block;
            width: 19%;
            height: 99%;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            background-color: #535b63;
            color: #ffffff;
          }

          .text {
						display: inline-block;
						text-align: center;
						vertical-align: middle;
						font-weight: bold;
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
                echo "<a class='button'><p class='text'>Logged in as ";
                echo $_COOKIE['username'];
                echo "</p></a>";
            }
        }
        echo "<a class='button' href='/index.php'><p class='text'>Home</p></a>
            <a class='button' href='/add'><p class='text'>Add</p></a>
            <a class='button' href='/view'><p class='text'>View</p></a>";
        if (isset($_COOKIE['token']) && isset($_COOKIE['username'])) {
            if ($this->Login->check($_COOKIE['username'], $_COOKIE['token'])) {
                echo "<a class='button' href='/login/logout.php'><p class='text'>Log out</p></a>";
            } else {
                echo "<a class='button' href='/login'><p class='text'>Log in</p></a>
                    <a class='button' href='/register'><p class='text'>Sign up</p></a>";
            }
        } else {
            echo "<a class='button' href='/login'><p class='text'>Log in</p></a>
                <a class='button' href='/register'><p class='text'>Sign up</p></a>";
        }
        echo "</div><br>";
    }
}
