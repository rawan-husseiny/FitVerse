<?php
session_start();
include "db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user_id   = $_SESSION['user_id'];
$outfit_id = $_POST['outfit_id'] ?? 0;

if (!$outfit_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid outfit ID']);
    exit();
}

// Delete association from user_outfits first
$d1 = $conn->prepare("DELETE FROM user_outfits WHERE outfit_id = ? AND user_id = ?");
$d1->bind_param("ii", $outfit_id, $user_id);

if ($d1->execute()) {
    // Delete actual outfit record from outfits table
    $d2 = $conn->prepare("DELETE FROM outfits WHERE id = ?");
    $d2->bind_param("i", $outfit_id);
    $d2->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>