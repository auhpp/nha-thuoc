<?php
$pathExport = "";
if (isset($dateRequest)) {
    $pathExport = "/statistical/export?day=" . $dateRequest;
} else if (isset($weekRequest)) {
    $pathExport = "/statistical/export?week=" . $weekRequest;
} else if (isset($monthRequest)) {
    $pathExport = "/statistical/export?month=" . $monthRequest;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/statistical.css">

</head>
<body>
    <div class="container">
        <div class="inner-content">
            <!-- <h1 class="head-title">Thống kê</h1> -->
            <div class="form-request">
                <form class="input-group row" action="/revenueByDay">
                    <div class="col-4 label">Thống kê theo ngày</div>
                    <div class="col-6 group-input-btn">
                        <input
                            value="<?= $dateRequest ?? '' ?>"
                            class="form-control " type="date" id="day" name="day" required>
                        <button class="btn-submit btn btn-outline-secondary">Thống kê</button>
                    </div>
                </form>
                <form class="input-group row" action="/revenueByWeek">
                    <div class="col-4 label">Thống kê theo tuần</div>
                    <div class="col-6 group-input-btn">
                        <input
                            value="<?= $weekRequest ?? '' ?>"
                            class="form-control" type="week" id="week" name="week" required>
                        <button class="btn-submit btn btn-outline-secondary">Thống kê</button>
                    </div>
                </form>
                <form class="input-group row" action="/revenueByMonth">
                    <div class="col-4 label">Thống kê theo tháng</div>
                    <div class="col-6 group-input-btn">
                        <input
                            value="<?= $monthRequest ?? '' ?>"
                            class="form-control" type="month" id="month" name="month" required>
                        <button class="btn-submit btn btn-outline-secondary">Thống kê</button>
                    </div>
                </form>
            </div>

            <!-- Result table -->
            <div class="result-table">
                <!-- Table Starts Here -->
                <h3 class="title">Doanh thu dựa theo hóa đơn</h3>
                <a href="<?= $pathExport ?>" class="btn btn-export btn-large btn-success">📥 Xuất Excel</a>
                <table id="bill-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Mã hóa đơn</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Ngày lập</th>
                            <th scope="col">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($priceResult as $price) : ?>
                            <tr>
                                <td><?= htmlspecialchars($price->id) ?></td>
                                <td><?= htmlspecialchars($price->customerName) ?></td>
                                <td><?= htmlspecialchars($price->phoneNumber) ?></td>
                                <td><?= htmlspecialchars(date("d-m-Y", strtotime($price->createdAt))) ?></td>
                                <td><?= htmlspecialchars(number_format($price->amount, 0, ',', '.')) ?> VNĐ</td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <div class="row">
                    <h3 class="col-2 title-revenue">Tổng doanh thu: </h3>
                    <span class="col-2 total-revenue"><?= htmlspecialchars(number_format($totalRevenue, 0, ',', '.')) ?> VNĐ</span>
                </div>
                <!-- Table Ends Here -->
            </div>

            <div class="result-table">
                <!-- Table Starts Here -->
                <h3 class="title">Doanh thu theo thuốc bán chạy</h3>
                <table id="medicine-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Tên thuốc</th>
                            <th scope="col">Số lượng bán</th>
                            <th scope="col">Tổng doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicineResult as $medicine) : ?>
                            <tr>
                                <td><?= htmlspecialchars($medicine->medicineName) ?></td>
                                <td><?= htmlspecialchars($medicine->sold . " " . $medicine->unit) ?></td>
                                <td><?= htmlspecialchars(number_format($medicine->amount, 0, ',', '.')) ?> VNĐ</td>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <!-- Table Ends Here -->
            </div>

            <div class="result-table">
                <!-- Table Starts Here -->
                <h3 class="title">Doanh thu theo khách hàng</h3>
                <table id="customer-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Mã khách hàng</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Tổng chi tiêu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customerResult as $customer) : ?>
                            <tr>
                                <td><?= htmlspecialchars($customer->customerId) ?></td>
                                <td><?= htmlspecialchars($customer->customerName) ?></td>
                                <td><?= htmlspecialchars($customer->phoneNumber) ?></td>
                                <td><?= htmlspecialchars(number_format($customer->amount, 0, ',', '.')) ?> VNĐ</td>


                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <!-- Table Ends Here -->
            </div>
        </div>

    </div>
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let table = new DataTable('#bill-table', {
            responsive: true,
            pagingType: 'simple_numbers'
        });
        let medicineTable = new DataTable('#medicine-table', {
            responsive: true,
            pagingType: 'simple_numbers'
        });
        let customerTable = new DataTable('#customer-table', {
            responsive: true,
            pagingType: 'simple_numbers'
        });
    </script>
</body>

</html>