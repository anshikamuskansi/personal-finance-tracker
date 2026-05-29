<?php
include 'main/db.php';

$message = "";
$message_class = "";

if(isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // FIXED: Using 'accounts' and 'email_address' to match your phpMyAdmin table perfectly
    $check_email = mysqli_query($conn, "SELECT * FROM accounts WHERE email_address='$email'");
    
    if(!$check_email) {
        $message = "Database Query Error: " . mysqli_error($conn);
        $message_class = "alert-danger";
    } else if(mysqli_num_rows($check_email) > 0) {
        $message = "This email is already registered!";
        $message_class = "alert-danger";
    } else {
        // FIXED: Using your new column names: full_name, email_address, security_hash
        $sql = "INSERT INTO accounts (full_name, email_address, security_hash) 
                VALUES ('$name', '$email', '$password')";
                
        if(mysqli_query($conn, $sql)) {
            $message = "Registration Successful! Redirecting to sign in...";
            $message_class = "alert-success";
            header("refresh:2;url=login.php");
        } else {
            $message = "Database Error: " . mysqli_error($conn);
            $message_class = "alert-danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Personal Finance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
        }
        .register-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-box">
        <h2 class="text-center mb-4 fw-bold">Create Account</h2>

        <?php if(!empty($message)): ?>
            <div class="alert <?php echo $message_class; ?> text-center py-2 small" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
            </div>

            <button type="submit" name="register" class="btn btn-success w-100 text-white fw-bold py-2">Register</button>
        </form>

        <p class="text-center mt-4 small text-muted">
            Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In here</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>