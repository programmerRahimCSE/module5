<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        session_unset();
        session_destroy();
        setcookie("successMsg", "logout Successful!", time() + 5);
    }
    header("Location: login.php");
?>