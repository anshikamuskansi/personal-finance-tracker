<!-- php
session_start();
include 'includes/db.php';

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);

    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];

        header("Location: dashboard.php");

    } else {
        echo "Invalid Credentials";
    }
}


<form method="POST">
    <input type="email" name="email">
    <input type="password" name="password">

    <button type="submit" name="login">Login</button>
</form> -->
<?php
session_start();
// 1. Ensure this path matches your folder structure (main/db.php or includes/db.php)
include 'includes/db.php'; 

$error_message = "";

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure the input slightly to prevent basic SQL broken queries
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the hashed password
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid Password!";
        }
    } else {
        $error_message = "No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Finance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2 class="text-center mb-4">Login</h2>

        <?php if(!empty($error_message)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="enter your email" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="enter your password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100 mt-2">Login</button>
        </form>

        <p class="text-center mt-3 small text-muted">
            Don't have an account? <a href="register.php" class="text-success text-decoration-none">Register here</a>
        </p>
    </div>
</div>

</body>
</html>