<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: loginMM.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id      = $_SESSION['user_id'];
    $gender       = $_POST['gender'] ?? 'Male';
    $clothes_type = $_POST['clothes_type'] ?? '';
    $height       = (int)($_POST['height'] ?? 0);
    $weight       = (int)($_POST['weight'] ?? 0);
    $body_shape   = $_POST['body_shape'] ?? '';
    $top_size     = $_POST['top_size'] ?? '';
    $bottom_size  = $_POST['bottom_size'] ?? '';
    $dress_size   = $_POST['dress_size'] ?? '';
    $jean_size    = (int)($_POST['jean_size'] ?? 0);

    // Update gender in users table
    $stmtUser = $conn->prepare("UPDATE users SET gender = ? WHERE id = ?");
    $stmtUser->bind_param("si", $gender, $user_id);
    $stmtUser->execute();

    // Check if style profile exists
    $check = $conn->prepare("SELECT id FROM style_profiles WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE style_profiles SET 
            clothes_type=?, height=?, weight=?, body_shape=?,
            top_size=?, bottom_size=?, dress_size=?, jean_size=?
            WHERE user_id=?");
        $stmt->bind_param("siissssii", $clothes_type, $height, $weight, $body_shape,
                          $top_size, $bottom_size, $dress_size, $jean_size, $user_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO style_profiles 
            (user_id, clothes_type, height, weight, body_shape, top_size, bottom_size, dress_size, jean_size)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isiissssi", $user_id, $clothes_type, $height, $weight, $body_shape,
                          $top_size, $bottom_size, $dress_size, $jean_size);
    }

    if ($stmt->execute()) {
        header("Location: outfit_result.php");
        exit();
    } else {
        echo "❌ Error saving profile: " . $stmt->error;
    }
}
?>