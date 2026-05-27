<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Glovix.Co - Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
background:url("{{ asset('images/background.jpeg') }}") center/cover no-repeat;
display:flex;
justify-content:center;
align-items:center;
}

.register-box{
width:400px;
padding:40px;
border-radius:20px;
background:rgba(255,255,255,0.1);
backdrop-filter:blur(20px);
border:1px solid rgba(255,255,255,0.2);
color:white;
}

.register-box h2{
text-align:center;
margin-bottom:25px;
}

.input-box{
position:relative;
margin-bottom:18px;
}

.input-box input{
width:100%;
padding:12px 40px 12px 15px;
border-radius:30px;
border:none;
outline:none;
background:rgba(255,255,255,0.2);
color:white;
}

.input-box input::placeholder{
color:#eee;
}

.input-box i{
position:absolute;
right:15px;
top:50%;
transform:translateY(-50%);
}

.btn{
width:100%;
padding:12px;
border-radius:30px;
border:none;
background:white;
font-weight:600;
cursor:pointer;
}

.btn:hover{
background:#ddd;
}

.login-link{
text-align:center;
margin-top:18px;
font-size:14px;
}

.login-link a{
color:white;
text-decoration:none;
font-weight:500;
}

</style>
</head>

<body>

<div class="register-box">

<h2>Register</h2>

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="input-box">
<input type="text" name="name" placeholder="Full Name" required>
<i class='bx bxs-user'></i>
</div>

<div class="input-box">
<input type="email" name="email" placeholder="Email" required>
<i class='bx bxs-envelope'></i>
</div>

<div class="input-box">
<input type="password" name="password" placeholder="Password" required>
<i class='bx bxs-lock-alt'></i>
</div>

<div class="input-box">
<input type="password" name="password_confirmation" placeholder="Confirm Password" required>
<i class='bx bxs-lock'></i>
</div>

<button type="submit" class="btn">Register</button>

<div class="login-link">
Already have an account?
<a href="{{ route('login') }}">Login</a>
</div>

</form>

</div>

</body>
</html>