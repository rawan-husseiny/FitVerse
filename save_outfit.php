<?php
session_start();
include "db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user_id    = $_SESSION['user_id'];
$image      = $_POST['image']      ?? '';
$gender     = $_POST['gender']     ?? '';
$category   = $_POST['category']   ?? '';
$body_shape = $_POST['body_shape'] ?? '';

if (!$image) {
    echo json_encode(['success' => false, 'message' => 'No image provided']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO outfits (name, image, gender, category, body_shape) VALUES (?, ?, ?, ?, ?)");
$name = "AI Outfit - " . date('Y-m-d H:i');
$stmt->bind_param("sssss", $name, $image, $gender, $category, $body_shape);

if ($stmt->execute()) {
    $outfit_id = $conn->insert_id;

    $stmt2 = $conn->prepare("INSERT INTO user_outfits (user_id, outfit_id) VALUES (?, ?)");
    $stmt2->bind_param("ii", $user_id, $outfit_id);
    $stmt2->execute();

    echo json_encode(['success' => true, 'message' => 'Outfit saved!']);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
?>