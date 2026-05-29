<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background-color:#f5f5f5;
        }

        .hero{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            text-align:center;
        }

        .box{
            background:white;
            padding:50px;
            border-radius:15px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        h1{
            font-weight:bold;
            margin-bottom:20px;
        }

        p{
            margin-bottom:30px;
            color:gray;
        }

    </style>

</head>
<body>

<div class="hero">

    <div class="box">

        <h1>Personal Finance Tracker</h1>

        <p>
            Manage your income and expenses easily.
        </p>

        <a href="register.php" class="btn btn-success me-3">
            Register
        </a>

        <a href="login.php" class="btn btn-primary">
            Login
        </a>

    </div>

</div>

</body>
</html>