<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <?php require_once __DIR__ . '/header.php'; ?>
</head>
<body>
    <div class="container">
        <div class="auth-box">
            <h2>Đăng ký</h2>
            <form action="/register" method="POST">
                <input type="text" name="username" placeholder="Tên đăng nhập" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                <button type="submit">Đăng ký</button>
            </form>
            <p>Đã có tài khoản? <a href="login">Đăng nhập</a></p>
        </div>
    </div>
</body>
</html>
