<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedicineSearch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/medicine_search.css">
    <?php require_once __DIR__ . '/header.php'; ?>
    <style>
        th, td {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto search">
                <input class="search-input" placeholder="Tìm kiếm sản phẩm"/>
                <div class="options">
                    <button class="search-btn">
                        <h4>Tìm kiếm theo</h4>
                    </button>
                    <ul class="options-list">
                        <li><a class="menu-item" href="#" data-url="/medicine_searchByCategory/{param}">Loại thuốc</a></li>
                        <li><a class="menu-item" href="#" data-url="/medicine_searchByHSX/{param}">Hãng sản xuất</a></li>
                        <li><a class="menu-item" href="#" data-url="/medicine_searchByNCC/{param}">Nhà cung cấp</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row result">
            <div class="col-md-10 mx-auto">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên thuốc</th>
                        <th scope="col">Công dụng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Số lượng tồn</th>
                        <th scope="col">Hạn sử dụng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($medicines)): ?>
                            <?php for ($index = 0 ; $index < count($medicines); $index++): ?>
                                <tr>
                                    <th scope="row"><?=$index?></th>
                                    <td><?= $medicines[$index]->medicineName?></td>
                                    <td><?= $medicines[$index]->medicineEffect?></td>
                                    <td><?= $medicines[$index]->medicinePrice?></td>
                                    <td><?= $medicines[$index]->medicineInventory?></td>
                                    <td><?= $medicines[$index]->medicineExpiry?></td>
                                </tr>
                            <?php endfor ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll(".menu-item").forEach(item => {
        item.addEventListener("click", function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>

        const searchInput = document.querySelector(".search-input").value.trim(); // Lấy giá trị ô input
        if (!searchInput) {
            alert("Vui lòng nhập nội dung tìm kiếm!"); // Kiểm tra nếu input trống
            return;
        }

        let baseUrl = this.getAttribute("data-url"); // Lấy URL từ data-url
        let url = baseUrl.replace("{param}", encodeURIComponent(searchInput)); // Thay thế {param} bằng giá trị tìm kiếm

        window.location.href = url; // Chuyển hướng đến URL mới
        });
    });
    </script>
</body>
</html>

