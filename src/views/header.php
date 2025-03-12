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
#he1 {
    font-size: 1.8rem;
    font-weight: bold;
}

/* Màu nền và hiệu ứng hover cho các mục điều hướng */
#navbar-nav1 .nav-link1 {
    font-size: 1.1rem;
    font-weight: 500;
    padding: 10px 15px;
    transition: all 0.3s ease-in-out;
}



/* Hiệu ứng khi active */
#navbar-nav1 .nav-item .nav-link.active {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 8px;
}
.navbar .fo a{
    font-size: 20px;
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
    <header style="height: 68px;">
        <nav id="he" class="navbar navbar-expand-lg navbar-dark "style="background-color: #009B49; color: white; height: 68px;">
            <div class="container fo" style="max-width: 100%;height: 68px;padding: 0 12px;">
                <a id="he1" class="navbar-brand" href="medicine" style="font-size: 28px;">Nhà Thuốc</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">
                    <ul id="navbar-nav1" class="navbar-nav ">
                        <li class="nav-item">
                            <a class="nav-link nav-link1" href="/medicine" style="font-size: 18px;">Danh sách thuốc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link1" href="/medicine/add" style="font-size: 18px;">Thêm thuốc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link1" href="/medicine_search" style="font-size: 18px;">Tìm kiếm thuốc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link1" href="/statistical" style="font-size: 18px;">Thống kê</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
