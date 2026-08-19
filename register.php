<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email2'];
    $age        = $_POST['age'];
    $password   = $_POST['password2'];
    $gender     = $_POST['gender'];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: loginMM.php?register=email_exists");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users
    (first_name, last_name, phone, email, age, password, gender)
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssiss", $first_name, $last_name, $phone, $email, $age, $hashed_password, $gender);

    if ($stmt->execute()) {
        header("Location: loginMM.php?register=success");
        exit();
    } else {
        header("Location: loginMM.php?register=error");
        exit();
    }
}
?>
