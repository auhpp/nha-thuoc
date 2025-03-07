<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/statistical.css">
</head>

<body>
    <h1>Thống kê</h1>
    <form action="/revenueByDay">
        <input type="date" id="day" name="day" required>
        <button>Submit</button>
    </form>
    <form action="/revenueByWeek">
        <input type="week" id="week" name="week" required>
        <button>Submit</button>
    </form>
    <form action="/revenueByMonth">
        <input type="month" id="month" name="month" required>
        <button>Submit</button>
    </form>
</body>

</html>