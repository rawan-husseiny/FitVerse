<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginM.css">
    <style>
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 14px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>

    <div class="card">

        <!-- Image -->
        <div class="image-box">
            <img src="image-web/login-img.jpeg" alt="login image" width="100%" height="100%" style="border-radius: 25px;">
        </div>

        <!-- Form -->
        <div class="form-box">
            
            <div id="loginForm">
                <form action="./login.php" method="post">
                <h2>Login</h2>
                <?php
                    if(isset($_SESSION['error'])){
                        $error = $_SESSION['error'] ;
                        echo "<p style='color:red; text-align: center;' >  $error   </p>";
                        unset($_SESSION['error']);
                    }
            
                if(isset($_SESSION["success"])) {
                    $success= $_SESSION['success'] ;
                    echo "<p style='color:green; text-align: center;' >  $success  </p>";
                    unset($_SESSION['success']);
                }

            ?>
        

                <!-- Status message shown here -->
                <div id="statusMessage"></div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="text" name="email1" id="email" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password1" id="password" required>
                </div>

                <button type="submit">Login</button>
                </form>
                <div class="links">
                    <a href="#" onclick="showForm('create')">Create an account</a>
                    <a href="forgot_password.php">Forget Password</a>
                </div>
            
            </div>


            
            <!-- CREATE ACCOUNT -->
            <div class="box" id="createForm">
            <h2>Create Account</h2>

            <!-- Status message shown here when on create form -->
            <div id="createStatusMessage"></div>

            <form action="./register.php" method="post">

                    <input class="rou" type="text" placeholder="First Name" name="first_name" required>
                    <input class="rou" type="text" placeholder="Last Name" name="last_name" required>
                    <input class="rou" type="email" placeholder="Email" name="email2" required>
                    <input class="rou" type="text" placeholder="Phone" name="phone" required>
                    <input class="rou" type="number" placeholder="Age" name="age" required>
                    <input class="rou" type="password" placeholder="Password" name="password2" required>

            <!-- Gender -->
            <div class="gender">
                <label><input type="radio" name="gender" value="Male"> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>
            
            <button type="submit">Sign Up</button>
            </form>
            

            <div class="links">
                <a onclick="showForm('login')">Back to Login</a>
            </div>
            </div>

            <!-- FORGOT PASSWORD -->
            <div class="box" id="forgotForm">
            <h2>Reset Password</h2>

            <input class="rou" type="email" placeholder="Enter your email" name="email">
            <input class="rou" type="password" placeholder="New Password" name="Password">

            <button>Confirm</button>

            <div class="links">
                <a onclick="showForm('login')">Back to Login</a>
            </div>
            </div>
            

        </div>

    </div>
    

<script>
    function showForm(form) {
        document.getElementById("loginForm").style.display = "none";

        document.querySelectorAll(".box").forEach(f => {
            f.classList.remove("active");
        });

        if (form === "login") {
            document.getElementById("loginForm").style.display = "block";
        } else {
            const targetForm = document.getElementById(form + "Form");
            if (targetForm) {
                targetForm.classList.add("active");
            }
        }
    }

    function handleRegisterStatus() {
        const params = new URLSearchParams(window.location.search);
        const status = params.get("register");

        if (!status) return;

        const messages = {
            success:      { text: "✅ Account created successfully! Please log in.", cls: "alert-success", form: "login" },
            email_exists: { text: "⚠️ This email is already registered. Please use a different email or log in.", cls: "alert-warning", form: "create" },
            error:        { text: "❌ Something went wrong. Please try again.", cls: "alert-error", form: "create" }
        };

        const msg = messages[status];
        if (!msg) return;

        // Show the correct form panel
        showForm(msg.form);

        // Pick the right message container
        const containerId = msg.form === "login" ? "statusMessage" : "createStatusMessage";
        const container = document.getElementById(containerId);
        container.innerHTML = `<div class="alert ${msg.cls}">${msg.text}</div>`;

        // Clean the URL so a refresh doesn't re-show the message
        history.replaceState(null, "", window.location.pathname);
    }

    handleRegisterStatus();
</script>
</body>
</html>
