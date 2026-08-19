<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: loginMM.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT first_name, last_name, email, photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $photo_path = $user['photo'];

    if (!empty($_FILES['photo']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext     = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Only JPG, PNG, and WEBP images are allowed.";
        } elseif ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
            $error = "Image must be under 2MB.";
        } else {
            $filename   = "user_" . $user_id . "_" . time() . "." . $ext;
            $upload_dir = "image-web/";
            move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $filename);
            $photo_path = $upload_dir . $filename;
        }
    }

    if (!$error) {
        $stmt2 = $conn->prepare("UPDATE users SET first_name=?, last_name=?, photo=? WHERE id=?");
        $stmt2->bind_param("sssi", $first_name, $last_name, $photo_path, $user_id);
        if ($stmt2->execute()) {
            header("Location: profile.php");
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}

$photo = !empty($user['photo']) ? htmlspecialchars($user['photo']) : "image-web/profile-img1.jpg";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">-
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .edit-container { max-width: 500px; margin: 0 auto; padding: 20px; }
        .photo-upload { display: flex; flex-direction: column; align-items: center; margin: 20px 0 30px; }
        .photo-preview { width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.15); margin-bottom: 12px; cursor: pointer; position: relative; }
        .photo-preview img { width: 100%; height: 100%; object-fit: cover; }
        .photo-preview .overlay { position: absolute; bottom: 0; left: 0; width: 100%; height: 35%; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.75rem; }
        #photoInput { display: none; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.78rem; text-transform: uppercase; color: #666; margin-bottom: 6px; letter-spacing: 0.05em; }
        .form-group input { width: 100%; padding: 12px 16px; border: none; border-radius: 14px; background: rgba(255,255,255,0.6); font-size: 0.95rem; outline: none; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
        .save-btn { width: 100%; padding: 14px; background-color: #4b5d4a; color: #fff; border: none; border-radius: 25px; font-size: 1rem; cursor: pointer; margin-top: 10px; }
        .save-btn:hover { background-color: #3a4a39; }
        .msg-error { background: #fde8e8; color: #b00020; padding: 10px 16px; border-radius: 12px; margin-bottom: 16px; font-size: 0.9rem; }
        .page-title { text-align: center; font-size: 1.1rem; font-weight: 600; color: #333; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="mobile-container">

        <header class="top-nav">
            <a href="profile.php" style="color: black;"><i class="fa-solid fa-arrow-left"></i></a>
        </header>


        <div class="edit-container">
            <p class="page-title">Edit Profile</p>


            <?php if ($error): ?>
                <div class="msg-error"><?= $error ?></div>
            <?php endif; ?>


            <form action="edit_profile.php" method="POST" enctype="multipart/form-data">

                <div class="photo-upload">
                    <div class="photo-preview" onclick="document.getElementById('photoInput').click()">
                        <img src="<?= $photo ?>" alt="Profile Photo" id="previewImg">
                        <div class="overlay"><i class="fa-solid fa-camera"></i> change</div>
                    </div>


                    <input type="file" name="photo" id="photoInput" accept="image/*">
                </div>


                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>
                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('photoInput').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('previewImg').src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
