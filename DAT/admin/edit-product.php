<?php
include('../../includes/db.php');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>❌ Thiếu ID sản phẩm.</div>";
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
if (mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-warning'>❌ Không tìm thấy sản phẩm.</div>";
    exit;
}

$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Nếu có upload ảnh mới
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "../assets/images/" . basename($image_name);

        if (move_uploaded_file($image_tmp, $image_path)) {
            $image_sql = ", image = '$image_name'";
        } else {
            echo "<div class='alert alert-danger'>❌ Lỗi khi lưu ảnh mới.</div>";
            $image_sql = '';
        }
    } else {
        $image_sql = '';
    }

    $update = "UPDATE products SET name = '$name', price = $price $image_sql WHERE id = $id";
    mysqli_query($conn, $update);

    echo "<div class='alert alert-success'>✅ Cập nhật sản phẩm thành công.</div>";
    echo "<a href='index.php' class='btn btn-primary mt-3'>← Quay lại danh sách</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-header">
      <h4>Sửa sản phẩm</h4>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Tên sản phẩm</label>
          <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Giá</label>
          <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Ảnh mới (nếu muốn thay)</label>
          <input type="file" name="image" class="form-control">
          <p class="mt-2">Ảnh hiện tại: <strong><?= $product['image'] ?></strong></p>
          <img src="../assets/images/<?= $product['image'] ?>" alt="" width="120" class="img-thumbnail mt-2">
        </div>
        <button type="submit" class="btn btn-success"> Cập nhật</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>
