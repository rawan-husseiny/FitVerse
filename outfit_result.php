<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: loginMM.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. جلب اختيارات المستخدم الأخيرة
$gender     = $_SESSION['quiz_gender']     ?? 'Female';
$body_shape = $_SESSION['quiz_body_shape'] ?? 'Hourglass';
$style_type = $_SESSION['quiz_style_type'] ?? 'Casual';

try {
    $profile_sql = "SELECT * FROM user_profiles WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
    $profile_res = $conn->query($profile_sql);
    if ($profile_res && $profile_res->num_rows > 0) {
        $p_row = $profile_res->fetch_assoc();
        $gender     = $p_row['gender']       ?? $gender;
        $body_shape = $p_row['body_shape']   ?? $body_shape;
        $style_type = $p_row['clothes_type']  ?? $p_row['style_type'] ?? $style_type;
    }
} catch (Exception $e) {}

// قيم افتراضية للتفاصيل
$outfit_id    = 0;
$image_path   = "./image-web/quistion-img2.jpg"; 
$outfit_title = "Elegantly Chic " . ucfirst($style_type);
$top_pick     = "Structured Blazer / Fitting Top";
$bottom_pick  = "High-Waisted Wide Leg Pants";
$shoes_pick   = "Minimalist Leather Loafers / Heels";

// 2. جلب بيانات الطقم والصورة من قاعدة البيانات
$outfit_sql = "SELECT * FROM outfits WHERE gender = '$gender' AND body_shape = '$body_shape' LIMIT 1";

try {
    $outfit_result = $conn->query($outfit_sql);
    if ($outfit_result && $outfit_result->num_rows > 0) {
        $outfit_row = $outfit_result->fetch_assoc();
        
        $outfit_id  = $outfit_row['id'] ?? 0;
        $image_path = $outfit_row['image_path'] ?? $outfit_row['image'] ?? $outfit_row['img'] ?? $image_path;
        
        if (!empty($outfit_row['title']))       $outfit_title = $outfit_row['title'];
        elseif (!empty($outfit_row['name']))    $outfit_title = $outfit_row['name'];
        
        if (!empty($outfit_row['top_pick']))    $top_pick     = $outfit_row['top_pick'];
        if (!empty($outfit_row['bottom_pick'])) $bottom_pick  = $outfit_row['bottom_pick'];
        if (!empty($outfit_row['shoes_pick']))  $shoes_pick   = $outfit_row['shoes_pick'];
    }
} catch (Exception $e) {}

// 3. معالجة حفظ الـ Outfit عند الضغط على زر Save to Profile
if (isset($_POST['save_outfit'])) {
    $saved_outfit_id = intval($_POST['outfit_id']);
    $saved_image     = $conn->real_escape_string($_POST['image_path']);
    $saved_title     = $conn->real_escape_string($_POST['outfit_title']);

    // حفظ البيانات في جدول الـ saved_outfits (إذا كان الجدول موجوداً)
    $save_sql = "INSERT INTO saved_outfits (user_id, outfit_id, image_path, outfit_title) 
                 VALUES ('$user_id', '$saved_outfit_id', '$saved_image', '$saved_title')";
    
    try {
        $conn->query($save_sql);
    } catch (Exception $e) {
        // في حال عدم وجود جدول مخصص للحفظ
    }

    // التوجيه المباشر إلى صفحة البروفايل
    header("Location: profile.php");
    exit();
}

$outfit_desc = "Based on your $body_shape body frame, we selected clean lines with balanced proportions to highlight your best features effortlessly.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Style Match | Outfit Result</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="outfit-style.css">
</head>
<body>

  <!-- Navigation Bar -->
  <div class="top-nav">
      <a href="home3.html"><i class="fa-solid fa-house"></i> Home</a>
      <a href="profile.php">Profile <i class="fa-solid fa-user"></i></a>
  </div>

  <main class="result-container">
    
    <!-- Hero Header Section -->
    <header class="result-header">
      <span class="badge">Custom Recommendation ✨</span>
      <h1>Your Personalized Outfit</h1>
      <p>Tailored specifically for your <strong><?php echo htmlspecialchars($body_shape); ?></strong> body shape.</p>
    </header>

    <!-- Main Outfit Card Grid -->
    <section class="outfit-grid">
      
      <!-- Recommended Look Details Card -->
      <article class="card outfit-details">
        <div class="card-tag">Stylist Choice</div>
        <h2><?php echo htmlspecialchars($outfit_title); ?></h2>
        <p class="description"><?php echo htmlspecialchars($outfit_desc); ?></p>

        <div class="specs-list">
          <div class="spec-item">
            <i class="fa-solid fa-vest"></i>
            <div>
              <small>Top Pick</small>
              <strong><?php echo htmlspecialchars($top_pick); ?></strong>
            </div>
          </div>
          <div class="spec-item">
            <i class="fa-solid fa-user-ninja"></i>
            <div>
              <small>Bottom Pick</small>
              <strong><?php echo htmlspecialchars($bottom_pick); ?></strong>
            </div>
          </div>
          <div class="spec-item">
            <i class="fa-solid fa-shoe-prints"></i>
            <div>
              <small>Footwear</small>
              <strong><?php echo htmlspecialchars($shoes_pick); ?></strong>
            </div>
          </div>
        </div>
      </article>

      <!-- Outfit Preview Showcase / Image Card -->
      <article class="card outfit-preview">
        <div class="image-wrapper">
          <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($outfit_title); ?>" id="outfitImg">
        </div>
      </article>

    </section>

    <!-- Action Buttons -->
    <footer class="action-buttons">
      <a href="questions.php" class="btn btn-secondary">
        <i class="fa-solid fa-rotate-left"></i> Retake Quiz
      </a>
      
      <!-- Form زر الحفظ إلى البروفايل -->
      <form method="POST" action="outfit_result.php" style="margin: 0;">
        <input type="hidden" name="outfit_id" value="<?php echo $outfit_id; ?>">
        <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($image_path); ?>">
        <input type="hidden" name="outfit_title" value="<?php echo htmlspecialchars($outfit_title); ?>">
        
        <button type="submit" name="save_outfit" class="btn btn-primary" style="border: none; cursor: pointer;">
          <i class="fa-solid fa-bookmark"></i> Save to Profile
        </button>
      </form>
    </footer>

  </main>

</body>
</html>