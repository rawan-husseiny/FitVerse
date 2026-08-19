<?php
session_start();
include "db.php";

$step = 1;
$email = '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Step 1: check email exists
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = "No account found with that email.";
            $step = 1;
        } else {
            $step = 2;
        }
    }

    // Step 2: save new password
    if (isset($_POST['new_password']) && isset($_POST['email_hidden'])) {
        $email = $_POST['email_hidden'];
        $new_password = $_POST['new_password'];
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed, $email);

        if ($stmt->execute()) {
            $_SESSION["success"] = "Password Changed";
            header("Location: loginMM.php");
            exit();
        } else {
            $message = "Something went wrong. Please try again.";
            $step = 1;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="loginM.css">
    <style>
        .error { color: red; font-size: 18px; margin-bottom: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <div class="image-box">
            <img src="image-web/login-img.jpeg" alt="login image" width="100%" height="100% " style="border-radius: 25px;">
        </div>

        <div class="form-box">
            <h2>Reset Password</h2>

            <?php if ($message): ?>
                <p class="error"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <?php if ($step === 1): ?>
            <!-- Step 1: enter email -->
            <form action="forgot_password.php" method="post">
                <input class="rou" type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Continue</button>
            </form>

            <?php elseif ($step === 2): ?>
            <!-- Step 2: enter new password -->
            <form action="forgot_password.php" method="post">
                <input type="hidden" name="email_hidden" value="<?= htmlspecialchars($email) ?>">
                <input class="rou" type="password" name="new_password" placeholder="New Password" required minlength="6">
                <button type="submit">Save New Password</button>
            </form>
            
            <?php endif; ?>
            

            <div class="links">
                <a href="loginMM.php">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
