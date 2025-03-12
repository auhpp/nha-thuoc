<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Nhà Thuốc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
.navbar {
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

/* Logo */
.navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
}

/* Màu nền và hiệu ứng hover cho các mục điều hướng */
.navbar-nav .nav-link {
    font-size: 1.1rem;
    font-weight: 500;
    padding: 10px 15px;
    transition: all 0.3s ease-in-out;
}



/* Hiệu ứng khi active */
.navbar-nav .nav-item .nav-link.active {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 8px;
}

/* Responsive */
@media (max-width: 992px) {
    .navbar-nav {
        text-align: center;
    }
    .navbar-nav .nav-item {
        margin-bottom: 5px;
    }
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark "style="background-color: #009B49; color: white;">
    <div class="container" >
        <a class="navbar-brand" href="medicine">Nhà Thuốc</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/medicine">Danh sách thuốc</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/medicine/add">Thêm thuốc</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/medicine_search">Tìm kiếm thuốc</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/statistical">Thống kê</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
