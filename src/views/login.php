<?php if (!empty($_SESSION["error_message"])): ?>
    <script>
        alert("<?php echo $_SESSION['error_message']; ?>");
    </script>
    <?php unset($_SESSION["error_message"]); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/auth.css">
   
</head>
<body>
    <div class="container">
        <div class="auth-box">
            <h2>Đăng nhập</h2>
            <form action="/login" method="POST">
                <input type="text" name="username" placeholder="Tên đăng nhập" required>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <button type="submit">Đăng nhập</button>
            </form>
            <p>Chưa có tài khoản? <a href="register">Đăng ký</a></p>
        </div>
    </div>
</body>
</html>
