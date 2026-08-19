<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    $success = $conn->query($sql) === TRUE;
    $conn->close();
    
    $card_icon  = $success ? '✅' : '❌';
    $card_title = $success ? 'Message Sent!' : 'Something went wrong';
    $card_msg   = $success
        ? "Thanks for reaching out. We've received your message and will get back to you as soon as possible."
        : "We couldn't send your message. Please try again in a moment.";
    $btn_text   = $success ? '← Back to Contact' : '← Try Again';
    $icon_bg    = $success ? '#e8f5e9' : '#fdecea';
    $title_col  = $success ? '#2e3b2f' : '#c0392b';

    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>$card_title</title>
    <link href='https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap' rel='stylesheet'>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Nunito', sans-serif;
            background: #f2f2f2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: white;
            border-radius: 24px;
            padding: 60px 50px;
            text-align: center;
            box-shadow: 0 8px 40px rgba(0,0,0,0.1);
            max-width: 480px;
            width: 90%;
            animation: pop 0.5s cubic-bezier(0.22,1,0.36,1);
        }
        @keyframes pop {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .icon {
            width: 80px; height: 80px;
            background: $icon_bg;
            border-radius: 50%;
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 2.5rem;
        }
        h2 { 
            font-size: 1.9rem;
            font-weight: 800;
            color: $title_col;
            margin-bottom: 12px;
        }
        p  { 
        color: #666;
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 32px;
        }
        a  {
            display: inline-block;
            background: #2e3b2f;
            color: white;
            text-decoration: none;
            padding: 13px 36px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 700;
            transition: opacity 0.2s;
        }
        a:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class='card'>
        <div class='icon'>$card_icon</div>
        <h2>$card_title</h2>
        <p>$card_msg</p>
        <a href='contact.html'>$btn_text</a>
    </div>
</body>
</html>";
}
?>
