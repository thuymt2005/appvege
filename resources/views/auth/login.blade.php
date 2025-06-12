<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .links {
            margin-top: 15px;
            text-align: center;
        }
        .links a {
            display: inline-block;
            margin: 5px 0;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
        <h2 style="text-align:center">Đăng nhập</h2>

        <label for="email">Email:</label>
        <input type="email" name="email" required placeholder="Nhập email">

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required placeholder="Nhập mật khẩu">

        <button type="submit">Đăng nhập</button>

        <div class="links">
            <a href="{{ route('register') }}">Đăng ký tài khoản</a><br>
            <a href="{{ route('forgot-password') }}">Quên mật khẩu?</a>
        </div>
    </form>

</body>
</html>
