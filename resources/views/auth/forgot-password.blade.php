<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; background: #f2f2f2; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .form { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #17a2b8; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #138496; }
    </style>
</head>
<body>

    <form method="POST" action="" class="form">
        @csrf
        <h2 style="text-align:center">Quên mật khẩu</h2>

        <input type="email" name="email" placeholder="Nhập email của bạn" required>

        <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
    </form>

</body>
</html>
