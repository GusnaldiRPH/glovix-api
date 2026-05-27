<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Glovix.Co - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            background: url("{{ asset('images/background.jpeg') }}") no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 380px;
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .input-box {
            position: relative;
            margin-bottom: 20px;
        }

        .input-box input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border-radius: 30px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .input-box input::placeholder {
            color: #eee;
        }

        .input-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .remember-forgot a {
            color: #fff;
            text-decoration: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            border: none;
            background: #fff;
            color: #333;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #e0e0e0;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 400px) {
            .login-box {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>

        <div class="remember-forgot">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            @endif
        </div>

        <button type="submit" class="btn">Login</button>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </div>
    </form>
</div>

</body>
</html>