<?php include('../../includes/db.php'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <h1 class="mb-4">🆕 Thêm sản phẩm mới</h1>

  <form method="post" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
      <label for="name" class="form-label">Tên sản phẩm:</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Giá:</label>
      <input type="number" name="price" id="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Chọn ảnh:</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
    </div>

    <button type="submit" name="submit" class="btn btn-success">➕ Thêm sản phẩm</button>
  </form>

<?php
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];

  // Xử lý ảnh
  $image_name = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  $image_folder_path = "../../assets/images/"; // Nơi lưu file vật lý (file thực)
  $image_relative_path = "assets/images/" . basename($image_name); // Đường dẫn lưu vào DB

  // Kiểm tra thư mục có tồn tại không
  if (!is_dir($image_folder_path)) {
    mkdir($image_folder_path, 0777, true); // Tạo thư mục nếu chưa có
  }

  if (move_uploaded_file($image_tmp, $image_folder_path . $image_name)) {
    $sql = "INSERT INTO products (name, image, price) VALUES ('$name', '$image_relative_path', $price)";
    if (mysqli_query($conn, $sql)) {
      echo "<div class='alert alert-success'>✅ Đã thêm sản phẩm thành công!</div>";
    } else {
      echo "<div class='alert alert-danger'>❌ Lỗi SQL: " . mysqli_error($conn) . "</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>❌ Không thể tải ảnh lên thư mục!</div>";
  }
}
?>

</body>
</html>
