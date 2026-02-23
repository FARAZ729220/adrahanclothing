<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Adrahan Clothing</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" />
</head>
<body>

    <div class="login-container">
        <h1 class="login-title">Admin Login</h1>

        <form class="login-form">
            <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-signin">SIGN IN</button>
        </form>

        <p class="demo-text">Demo: admin@oldmoney.com / admin123</p>
    </div>

</body>
</html>
