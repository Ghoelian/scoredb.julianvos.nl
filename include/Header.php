<?php
class Header
{
    public function echoHeader()
    {
        echo "<div class='header' style='width: 100%; height: 5%; background-color: rgb(50, 50, 50)'>
            <style>
            button {
            width: 19%;
            padding: 15px;
            background-color: #535b63;
            border: 0;
            box-sizing: border-box;
            cursor: pointer;
            font-weight: bold;
            color: #ffffff;
            }
            </style>";

        if (isset($_COOKIE['token']) && isset($_COOKIE['username'])) {
            if (checkLogin($_COOKIE['token'], $_COOKIE['username'])) {
                echo "<button type='button' disabled>Logged in as ";
                echo getName();
                echo "</button>";
            }
        }
        echo "<a href='/index.php'><button type='button'>Home</button></a>
            <a href='/add'><button type='button'>Add</button></a>
            <!--<button type='button'>Edit</button>-->
            <a href='/view'><button type='button'>View</button></a>";
        if (isset($_COOKIE['token']) && isset($_COOKIE['username'])) {
            if (checkLogin($_COOKIE['token'], $_COOKIE['username'])) {
                echo "<a href='/login/logout.php'><button type='button'>Log out</button></a>";
            }
        } else {
            echo "<a href='/login'><button type='button'>Log in</button></a>
                <a href='/register'><button type='button'>Sign up</button></a>";
        }
        echo "</div>";
    }
}