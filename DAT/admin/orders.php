<?php include('../../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách đơn hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
  <h2 class="mb-4"> Danh sách đơn hàng</h2>
  <a href="index.php" class="btn btn-secondary mb-3">← Quay lại Trang Admin</a>

  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Tên khách</th>
          <th>Sản phẩm</th>
          <th>Số lượng</th>
          <th>Tổng tiền</th>
          <th>Ngày đặt</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM orders";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
          echo "<tr><td colspan='6' class='text-danger fw-bold'>❌ Lỗi truy vấn: " . mysqli_error($conn) . "</td></tr>";
        } elseif (mysqli_num_rows($result) == 0) {
          echo "<tr><td colspan='6' class='text-center'>Không có đơn hàng nào.</td></tr>";
        } else {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>" . ($row['customers'] ?? '<em>Không có</em>') . "</td>
              <td>" . ($row['products'] ?? '<em>Không có</em>') . "</td>
              <td>{$row['quantity']}</td>
              <td>$" . number_format($row['total_price'], 2) . "</td>
              <td>{$row['order_date']}</td>
            </tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
