<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["loggedin"]);
if(session_destroy()) {
    header("Location:login.php");
}
?>