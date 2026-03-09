<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Adrahan Clothing</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#07070b;
            --panel:#0b0b12;
            --panel2:#0f0f18;
            --text:#eaeaf0;
            --muted:rgba(234,234,240,.65);
            --border:rgba(255,255,255,.08);
            --border2:rgba(255,255,255,.12);
            --purple:#a855f7;
            --purple2:#7c3aed;
            --danger:#ff5c7a;
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:28px 14px;
            font-family:'Montserrat', sans-serif;
            color:var(--text);
            background:
                radial-gradient(900px circle at 15% 20%, rgba(168,85,247,.18), transparent 55%),
                radial-gradient(900px circle at 85% 20%, rgba(124,58,237,.12), transparent 55%),
                radial-gradient(1200px circle at 50% 110%, rgba(168,85,247,.10), transparent 55%),
                var(--bg);
        }

        .wrap{
            width:100%;
            max-width:460px;
        }

        .card{
            background: rgba(11,11,18,.82);
            border:1px solid var(--border);
            border-radius:18px;
            overflow:hidden;
            box-shadow: 0 18px 60px rgba(0,0,0,.55);
            backdrop-filter: blur(14px);
        }

        .head{
            padding:22px 22px;
            background:
                radial-gradient(1200px circle at 30% 30%, rgba(168,85,247,.28), transparent 55%),
                var(--panel);
            border-bottom:1px solid var(--border);
        }

        .brand{
            font-weight:800;
            letter-spacing:.2px;
            font-size:18px;
        }
        .brand span{ color:var(--purple); }

        .subtitle{
            margin-top:8px;
            font-size:12px;
            color:var(--muted);
            line-height:1.5;
        }

        .body{
            padding:22px;
        }

        h1{
            margin:0 0 14px 0;
            font-family:'Playfair Display', serif;
            font-size:30px;
            font-weight:700;
            letter-spacing:.2px;
        }

        .hint{
            margin:0 0 18px 0;
            color:var(--muted);
            font-size:13px;
            line-height:1.6;
        }

        .field{
            margin-bottom:14px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-size:11px;
            letter-spacing:2px;
            font-weight:700;
            color:rgba(234,234,240,.75);
        }

        .input{
            width:100%;
            padding:14px 14px;
            border-radius:12px;
            background: rgba(255,255,255,.03);
            border:1px solid var(--border2);
            color:var(--text);
            outline:none;
            font-size:14px;
            transition:.2s;
        }

        .input::placeholder{
            color:rgba(234,234,240,.40);
        }

        .input:focus{
            border-color: rgba(168,85,247,.55);
            box-shadow: 0 0 0 4px rgba(168,85,247,.14);
        }

        .error{
            margin-top:8px;
            font-size:12px;
            color: #ffd1da;
            background: rgba(255,92,122,.10);
            border: 1px solid rgba(255,92,122,.25);
            padding:10px 12px;
            border-radius:12px;
        }

        .btn{
            width:100%;
            margin-top:8px;
            padding:13px 16px;
            border:none;
            border-radius:999px;
            font-weight:800;
            letter-spacing:2px;
            cursor:pointer;
            color:#fff;
            background: linear-gradient(90deg, var(--purple), var(--purple2));
            transition:.2s;
        }

        .btn:hover{
            transform: translateY(-1px);
            box-shadow: 0 14px 34px rgba(168,85,247,.18);
        }

        .btn:active{
            transform: translateY(0);
        }

        .foot{
            padding:16px 22px;
            border-top:1px solid var(--border);
            color:rgba(234,234,240,.55);
            font-size:12px;
            display:flex;
            justify-content:space-between;
            gap:10px;
            flex-wrap:wrap;
        }

        .small-link{
            color:rgba(234,234,240,.70);
            text-decoration:none;
        }
        .small-link:hover{ color:#fff; }

        /* optional - tiny responsive polish */
        @media (max-width: 420px){
            h1{ font-size:26px; }
            .body{ padding:18px; }
            .head{ padding:18px; }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="card">
            <div class="head">
                <div class="brand">Adrahan<span>.</span></div>
                <div class="subtitle">Secure access for administrators. Please sign in to manage products, categories and orders.</div>
            </div>

            <div class="body">
                <h1>Admin Login</h1>
                <p class="hint">Enter your admin credentials to continue.</p>

                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <div class="field">
                        <label>EMAIL</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="input"
                            placeholder="Enter your email"
                            autocomplete="email"
                        >
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>PASSWORD</label>
                        <input
                            type="password"
                            name="password"
                            class="input"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                        >
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn">SIGN IN</button>
                </form>
            </div>

            <div class="foot">
                <div>© {{ date('Y') }} Adrahan</div>
                <a class="small-link" href="{{ route('home')}}">Back to Store</a>
            </div>
        </div>
    </div>
</body>

</html>
