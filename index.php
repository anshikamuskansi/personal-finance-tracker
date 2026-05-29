<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
        }

        .welcome-box {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            max-width: 550px;
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .welcome-box:hover {
            transform: translateY(-5px);
        }

        .icon-wrapper {
            font-size: 3rem;
            color: #198754;
            margin-bottom: 15px;
        }

        h1 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 35px;
        }

        .btn-custom {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-register {
            background-color: #198754;
            color: #ffffff;
            border: none;
        }

        .btn-register:hover {
            background-color: #157347;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }

        .btn-login {
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
    </style>
</head>
<body>

<div class="hero-section">
    <div class="welcome-box">
        <div class="icon-wrapper">
            <span>₹</span>
        </div>

        <h1>Personal Finance Tracker</h1>
        <p>Take control of your money. Easily track your daily income, log your expenses, filter your spending habits, and manage your budget effortlessly.</p>

        <div class="d-flex justify-content-center gap-3">
            <a href="register.php" class="btn btn-custom btn-register btn-lg">
                Get Started
            </a>
            <a href="login.php" class="btn btn-custom btn-login btn-lg">
                Sign In
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>