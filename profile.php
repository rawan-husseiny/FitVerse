<?php
session_start();
include "db.php";

// block if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginMM.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// fetch user data
$stmt = $conn->prepare("SELECT first_name, last_name, email, gender, photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// fetch style profile
$stmt2 = $conn->prepare("SELECT * FROM style_profiles WHERE user_id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$profile = $stmt2->get_result()->fetch_assoc();

// safe fallbacks
$full_name   = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$photo       = !empty($user['photo']) ? htmlspecialchars($user['photo']) : "image-web/profile-img1.jpg";
$email       = htmlspecialchars($user['email']);
$gender      = htmlspecialchars($user['gender'] ?? 'N/A');
$height      = $profile ? htmlspecialchars($profile['height']) . ' cm' : 'N/A';
$weight      = $profile ? htmlspecialchars($profile['weight']) . ' kg' : 'N/A';
$clothes     = $profile ? htmlspecialchars($profile['clothes_type']) : 'N/A';
$body_shape  = $profile ? htmlspecialchars($profile['body_shape'])   : 'N/A';
$top_size    = $profile ? htmlspecialchars($profile['top_size'])     : 'N/A';
$bottom_size = $profile ? htmlspecialchars($profile['bottom_size'])  : 'N/A';
$dress_size  = $profile ? htmlspecialchars($profile['dress_size'])   : 'N/A';
$jean_size   = $profile ? htmlspecialchars($profile['jean_size'])    : 'N/A';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style Profile Design</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="mobile-container">
        <header class="top-nav">
            <a href="home3.html" style="color: black;">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </header>

        <section class="profile-header">
            <div class="profile-img-container">
                <img src="<?= $photo ?>" alt="User Photo">
            </div>
            
            <h1><?= $full_name ?></h1>
            <p class="email"><?= $email ?></p>
            <button class="edit-btn" onclick="window.location.href='edit_profile.php'">
                edit your profile <i class="fa-solid fa-pen"></i>
            </button>
        </section>

        <div class="stats-card">
            <div class="card-header">
                <span class="title">your style profile</span>
                <span class="view-all" onclick="document.getElementById('profileModal').classList.add('open')">view all <i class="fa-solid fa-chevron-right"></i></span>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="label">HEIGHT</span>
                    <span class="value"><?= $height ?></span>
                </div>
                <div class="stat-item">
                    <span class="label">WEIGHT</span>
                    <span class="value"><?= $weight ?></span>
                </div>
                <div class="stat-item">
                    <span class="label">GENDER</span>
                    <span class="value"><?= $gender ?></span>
                </div>
            </div>
        </div>

        <!-- View All Modal -->
        <div class="modal-overlay" id="profileModal">
            <div class="modal-box">
                <button class="modal-close" onclick="document.getElementById('profileModal').classList.remove('open')">✕</button>
                <h3>Full Style Profile</h3>
                <div class="modal-row">
                    <span class="mlabel">Height</span>
                    <span class="mvalue"><?= $height ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Weight</span>
                    <span class="mvalue"><?= $weight ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Gender</span>
                    <span class="mvalue"><?= $gender ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Clothes Type</span>
                    <span class="mvalue"><?= $clothes ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Body Shape</span>
                    <span class="mvalue"><?= $body_shape ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Top Size</span>
                    <span class="mvalue"><?= $top_size ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Bottom Size</span>
                    <span class="mvalue"><?= $bottom_size ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Dress Size</span>
                    <span class="mvalue"><?= $dress_size ?></span>
                </div>
                <div class="modal-row">
                    <span class="mlabel">Jean Waist Size</span>
                    <span class="mvalue"><?= $jean_size ?></span>
                </div>
            </div>
        </div>

        <style>
            .outfit-item { position: relative; }
            .outfit-item .delete-btn {
                display: none;
                position: absolute;
                top: 6px; right: 6px;
                background: rgba(180,0,0,0.75);
                color: #fff;
                border: none;
                border-radius: 50%;
                width: 26px; height: 26px;
                font-size: 0.75rem;
                cursor: pointer;
                align-items: center;
                justify-content: center;
                z-index: 10;
            }
            .outfit-item:hover .delete-btn { display: flex; }
        </style>

        <div class="outfits-grid" id="outs" style="max-height: 420px; overflow-y: auto; padding-right: 4px;">
            <?php
            $stmt3 = $conn->prepare("SELECT o.id, o.image, o.category FROM outfits o 
                INNER JOIN user_outfits uo ON o.id = uo.outfit_id 
                WHERE uo.user_id = ? ORDER BY o.created_at DESC");
            $stmt3->bind_param("i", $user_id);
            $stmt3->execute();
            $outfits = $stmt3->get_result();
            if ($outfits->num_rows === 0):
            ?>
                <p style="color:#666;font-size:0.85rem;grid-column:1/-1;text-align:center;padding:20px;">
                    No saved outfits yet. Generate and save one!
                </p>
            <?php else: while ($outfit = $outfits->fetch_assoc()): ?>
                <div class="outfit-item" id="outfit-<?= $outfit['id'] ?>">
                    <img src="<?= htmlspecialchars($outfit['image']) ?>" alt="<?= htmlspecialchars($outfit['category']) ?>">
                    <button class="delete-btn" onclick="deleteOutfit(<?= $outfit['id'] ?>)" title="Delete">✕</button>
                </div>
            <?php endwhile; endif; ?>
        </div>

        <script>
        function deleteOutfit(outfitId) {
            if (!confirm("Delete this outfit?")) return;
            fetch("delete_outfit.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "outfit_id=" + outfitId
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const el = document.getElementById("outfit-" + outfitId);
                    el.style.transition = "opacity 0.3s";
                    el.style.opacity = "0";
                    setTimeout(() => el.remove(), 300);
                } else {
                    alert("Error: " + data.message);
                }
            });
        }
        </script>

        <nav class="bottom-nav">
            <div class="nav-item">
                <a href="home3.html" style="color: rgb(255, 255, 255);"><i class="fa-solid fa-house"></i></a>
            </div>
            <div class="nav-item">
                <a href="contact.html" style="color: rgb(255, 255, 255);"><i class="fa-solid fa-phone"></i></a>
            </div>
            <div class="nav-item">
                <a href="#outs" style="color: white;">
                    <i class="fa-regular fa-heart" id="heart"></i>
                </a>
            </div>
            <div class="nav-item active">
                <a href="profile.php" style="color:rgb(255, 255, 255);"><i class="fa-regular fa-user"></i></a>
            </div>
        </nav>
    </div>

</body>
</html>
