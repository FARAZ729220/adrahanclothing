<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Adrahan Clothing</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" />
</head>

<body>

    <div class="login-container">
        <h1 class="login-title">Admin Login</h1>

        <form class="login-form" action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">EMAIL</label>

                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control login-contact-field ps-5 @error('email') is-invalid @enderror"
                    placeholder="Enter your email">
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="form-group">
                <label for="password">PASSWORD</label>

                <input type="password" id="login-password" name="password"
                    class="form-control login-contact-field ps-5 pe-5 @error('password') is-invalid @enderror"
                    placeholder="Enter your password">
            </div>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <button type="submit" class="btn-signin">SIGN IN</button>
        </form>

        <p class="demo-text">Demo: admin@oldmoney.com / admin123</p>
    </div>

</body>

</html>
