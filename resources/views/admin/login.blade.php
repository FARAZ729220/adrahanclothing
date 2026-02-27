{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Adrahan Clothing</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">
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

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Adrahan Clothing</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Montserrat:wght@400;500;600&display=swap"
        rel="stylesheet">
</head>

<body
    style="margin:0; padding:0; background:#f5f2ed; font-family:'Montserrat', sans-serif; display:flex; justify-content:center; align-items:center; height:100vh;">

    <div
        style="width:100%; max-width:420px; padding:40px; background:white; box-shadow:0 10px 40px rgba(0,0,0,0.08); border-radius:6px;">

        <h1
            style="font-family:'Playfair Display', serif; font-size:36px; margin-bottom:30px; text-align:left; color:#111;">
            Admin Login
        </h1>

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="font-size:12px; letter-spacing:2px; font-weight:600;">EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                    style="width:100%; padding:14px; margin-top:8px; border:1px solid #ddd; outline:none; font-size:14px;">
            </div>

            @error('email')
                <small style="color:red;">{{ $message }}</small>
            @enderror

            <div style="margin-bottom:20px;">
                <label style="font-size:12px; letter-spacing:2px; font-weight:600;">PASSWORD</label>
                <input type="password" name="password" placeholder="Enter your password"
                    style="width:100%; padding:14px; margin-top:8px; border:1px solid #ddd; outline:none; font-size:14px;">
            </div>

            @error('password')
                <small style="color:red;">{{ $message }}</small>
            @enderror

            <button type="submit"
                style="width:100%; padding:14px; background:black; color:white; border:none; letter-spacing:2px; font-weight:600; cursor:pointer; transition:0.3s;">
                SIGN IN
            </button>
        </form>

        {{-- <p style="margin-top:20px; font-size:13px; color:#777;">
            Demo: admin@oldmoney.com / admin123
        </p> --}}

    </div>

</body>

</html>
