<?php
session_start();
include "db.php";

$email    = $_POST['email1'] ?? '';
$password = $_POST['password1'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user']    = $user['email'];
    header("Location: home3.html");
    exit();
} else {
    $_SESSION["error"] = "Wrong Email or Password";
    header("Location: loginMM.php");
    exit();
}
?>
