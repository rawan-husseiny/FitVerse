<?php
session_start();

// if user is not logged in → block access
if (!isset($_SESSION['user'])) {
    header("Location: loginMM.php");
    exit();
}

?>
