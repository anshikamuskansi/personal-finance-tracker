<?php
session_start();
include 'main/db.php'; 

$error_message = "";

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure the input against basic SQL manipulation
    $email = mysqli_real_escape_string($conn, $email);

    // FIXED: Querying 'accounts' table and checking the 'email_address' column
    $sql = "SELECT * FROM accounts WHERE email_address='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // FIXED: Verifying password with the 'security_hash' column name
        if(password_verify($password, $user['security_hash'])) {
            // FIXED: Using 'account_id' instead of 'id' for the session tracking
            $_SESSION['user_id'] = $user['account_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid password! Please try again.";
        }
    } else {
        $error_message = "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Personal Finance Tracker</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 420px;
        }
        h2 {
            font-weight: 700;
            color: #212529;
        }
        .btn-login {
            background-color: #0d6efd;
            font-weight: 600;
            padding: 10px;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background-color: #0b5ed7;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2 class="text-center mb-4">Sign In</h2>

        <?php if(!empty($error_message)): ?>
            <div class="alert alert-danger text-center py-2 small" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Email Address</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-login w-100 text-white">Login</button>
        </form>

        <p class="text-center mt-4 small text-muted">
            Don't have an account? <a href="register.php" class="text-success fw-bold text-decoration-none">Register here</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>