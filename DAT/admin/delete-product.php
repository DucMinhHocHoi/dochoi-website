<?php
include('../../includes/db.php');

$id = $_GET['id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Xoá sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-body text-center">

<?php
if (!$id) {
    echo '<div class="alert alert-danger">❌ Thiếu ID sản phẩm.</div>';
} else {
    // Kiểm tra sản phẩm tồn tại
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    if (mysqli_num_rows($result) === 0) {
        echo '<div class="alert alert-warning">❌ Không tìm thấy sản phẩm.</div>';
    } else {
        // Xoá
        mysqli_query($conn, "DELETE FROM products WHERE id = $id");
        echo '<div class="alert alert-success">✅ Đã xoá sản phẩm thành công.</div>';
    }
}
?>

      <a href="index.php" class="btn btn-primary mt-3">← Quay lại danh sách</a>
    </div>
  </div>
</div>

</body>
</html>
