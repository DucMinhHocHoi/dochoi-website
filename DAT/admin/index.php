<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}
?>
<?php include('../../includes/db.php'); ?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản trị sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4">

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Quản trị sản phẩm</h1>
    <div class="dropdown">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Cài đặt
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="change-password.php">🔐 Đổi mật khẩu</a></li>
        <li><a class="dropdown-item" href="logout.php">🚪 Đăng xuất</a></li>
      </ul>
    </div>
  </div>

  <div class="mb-4">
    <a href="add-product.php" class="btn btn-primary btn-sm">➕ Thêm sản phẩm</a>
    <a href="orders.php" class="btn btn-outline-secondary btn-sm ms-2">📦 Quản lý đơn hàng</a>
  </div>

  <h4 class="mb-3">Danh sách sản phẩm</h4>

  <table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá tiền</th>
        <th class="text-center">Tùy chọn</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td>
          <img src="../../<?= $row['image'] ?>" width="50" class="img-thumbnail"
               onerror="this.onerror=null;this.src='../../assets/images/no-image.png';">
        </td>
        <td><?= $row['name'] ?></td>
        <td>$<?= number_format($row['price'], 2) ?></td>
        <td class="text-center">
          <a href="edit-product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
          <a href="delete-product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xoá sản phẩm này?')">🗑️ Xoá</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
