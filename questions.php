<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: loginMM.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Style Quiz</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="question-style.css">
</head>
<body>



<div class="container">

  <div class="top-nav">
    <a style="margin: 30px; margin-top: 20px; position: absolute ; color: black; font-weight: 600; text-decoration: none;" href="home3.html"><i style="margin-right: 7px;" class="fa-solid fa-house"></i>HOME</a>
  </div>

  <!-- STEP 3: Nice to meet you (أول مرحلة تظهر الآن) -->
  <input type="radio" name="step" id="s3" checked>
  <div class="step step3">
    <h1>Nice to meet you</h1>
    <div class="buttons">
      <label for="s1" class="btn">Let's get started</label>
    </div>
  </div>

  <!-- STEP 1: Gender -->
  <input type="radio" name="step" id="s1">
  <div class="step step1">
    <h1>What is your gender?</h1>
    <input list="genders" class="input" id="genderInput" placeholder="Select Gender">
    <datalist id="genders">
      <option value="Male">
      <option value="Female">
    </datalist>
    <div class="buttons">
      <label for="s4" class="btn disabled" id="next1">Next</label>
      <label for="s3" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 4: Clothes Type -->
  <input type="radio" name="step" id="s4">
  <div class="step step4">
    <h2>What types of clothes are you looking for?</h2>
    <input list="clothes" class="input" id="clothesInput" placeholder="Select Type">
    <datalist id="clothes">
      <option value="Casual">
      <option value="Workwear">
      <option value="Social occasions">
      <option value="Maternity">
    </datalist>
    <div class="buttons">
      <label for="s5" class="btn disabled" id="next4">Next</label>
      <label for="s1" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 5: Height -->
  <input type="radio" name="step" id="s5">
  <div class="step step5">
    <h2>How tall are you?</h2>
    <input type="number" class="input" id="heightInput" placeholder="Height in cm">
    <div class="buttons">
      <label for="s6" class="btn disabled" id="next5">Next</label>
      <label for="s4" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 6: Weight -->
  <input type="radio" name="step" id="s6">
  <div class="step step6">
    <h2>What's your weight?</h2>
    <input type="number" class="input" id="weightInput" placeholder="Weight in kg">
    <div class="buttons">
      <label for="s7" class="btn disabled" id="next6">Next</label>
      <label for="s5" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 7: Body Shape -->
  <input type="radio" name="step" id="s7">
  <div class="step step7">
    <h2>What's your body shape?</h2>
    <p>Select the shape that best describes your body</p>

    <input type="radio" name="shape" id="hourglass" value="Hourglass">
    <label class="option" for="hourglass">Hourglass<small>Waist is the narrowest part of frame</small></label>

    <input type="radio" name="shape" id="triangle" value="Triangle">
    <label class="option" for="triangle">Triangle<small>Hips are wider than shoulders</small></label>

    <input type="radio" name="shape" id="rectangle" value="Rectangle">
    <label class="option" for="rectangle">Rectangle<small>Shoulders, waist and hips are balanced</small></label>

    <input type="radio" name="shape" id="oval" value="Oval">
    <label class="option" for="oval">Oval<small>Waist is fuller than upper/lower body</small></label>

    <input type="radio" name="shape" id="heart" value="Heart">
    <label class="option" for="heart">Heart<small>Shoulders wider than hips</small></label>

    <div class="buttons">
      <label for="s8" class="btn">Continue</label>
      <label for="s6" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 8: Confirmation -->
  <input type="radio" name="step" id="s8">
  <div class="step step8">
    <h2>Thanks!</h2>
    <p>We'll take your details and create personalized styling recommendations for you.</p>
    <div class="buttons">
      <label for="s9" class="btn">Continue</label>
      <label for="s7" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 9: Tops Size -->
  <input type="radio" name="step" id="s9">
  <div class="step step9">
    <h2>Tops size</h2>
    <input type="text" class="input" id="topSize" placeholder="Size (S / M / L)">
    <div class="buttons">
      <label for="s10" class="btn disabled" id="next9">Next</label>
      <label for="s8" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 10: Bottoms Size -->
  <input type="radio" name="step" id="s10">
  <div class="step step10">
    <h2>Bottoms size</h2>
    <input type="text" class="input" id="bottomSize" placeholder="Size (S / M / L)">
    <div class="buttons">
      <label for="s11" class="btn disabled" id="next10">Next</label>
      <label for="s9" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 11: Dresses Size -->
  <input type="radio" name="step" id="s11">
  <div class="step step11">
    <h2>Dresses size</h2>
    <input type="text" class="input" id="dressSize" placeholder="Size (S / M / L)">
    <div class="buttons">
      <label for="s12" class="btn" id="next11">Next</label>
      <label for="s10" class="btn back">Back</label>
    </div>
  </div>

  <!-- STEP 12: Jean Waist Size -->
  <input type="radio" name="step" id="s12">
  <div class="step step12">
    <h2>Jean waist size</h2>
    <input type="number" class="input" id="jeanSize" placeholder="Waist in inches">
    <div class="buttons">
      <button class="btn" id="finishBtn">Finish</button>
      <label for="s11" class="btn back">Back</label>
    </div>
  </div>

</div>

<!-- Hidden Form -->
<form id="profileForm" action="save_profile.php" method="POST">
  <input type="hidden" name="gender"       id="h_gender">
  <input type="hidden" name="clothes_type" id="h_clothes">
  <input type="hidden" name="height"       id="h_height">
  <input type="hidden" name="weight"       id="h_weight">
  <input type="hidden" name="body_shape"  id="h_shape">
  <input type="hidden" name="top_size"    id="h_top">
  <input type="hidden" name="bottom_size" id="h_bottom">
  <input type="hidden" name="dress_size"  id="h_dress">
  <input type="hidden" name="jean_size"   id="h_jean">
</form>

<script>
  function toggle(inputId, btnId) {
    const input = document.getElementById(inputId);
    const btn   = document.getElementById(btnId);
    if (!input || !btn) return;
    
    input.addEventListener("input", () => {
      btn.classList.toggle("disabled", input.value.trim().length === 0);
    });
  }

  toggle("genderInput", "next1");
  toggle("clothesInput","next4");
  toggle("heightInput", "next5");
  toggle("weightInput", "next6");
  toggle("topSize",     "next9");
  toggle("bottomSize",  "next10");

  document.getElementById("finishBtn").addEventListener("click", () => {
    const shapeEl = document.querySelector('input[name="shape"]:checked');

    document.getElementById("h_gender").value  = document.getElementById("genderInput").value;
    document.getElementById("h_clothes").value = document.getElementById("clothesInput").value;
    document.getElementById("h_height").value  = document.getElementById("heightInput").value;
    document.getElementById("h_weight").value  = document.getElementById("weightInput").value;
    document.getElementById("h_shape").value   = shapeEl ? shapeEl.value : "";
    document.getElementById("h_top").value     = document.getElementById("topSize").value;
    document.getElementById("h_bottom").value  = document.getElementById("bottomSize").value;
    document.getElementById("h_dress").value   = document.getElementById("dressSize").value;
    document.getElementById("h_jean").value    = document.getElementById("jeanSize").value;

    document.getElementById("profileForm").submit();
  });
</script>
</body>
</html>