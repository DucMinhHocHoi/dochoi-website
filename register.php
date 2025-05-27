<?php
include 'includes/db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $check = $conn->query("SELECT * FROM customers WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $message = "Email đã được sử dụng!";
    } else {
        $conn->query("INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$password')");
        $message = "Đăng ký thành công! Vui lòng đăng nhập.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
  <div class="container">
    <h2 class="mb-3">Đăng ký tài khoản</h2>
    <?php if ($message): ?>
      <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label>Họ tên:</label>
        <input type="text" name="name" required class="form-control">
      </div>
      <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" required class="form-control">
      </div>
      <div class="mb-3">
        <label>Mật khẩu:</label>
        <input type="password" name="password" required class="form-control">
      </div>
      <button class="btn btn-primary">Đăng ký</button>
      <a href="login-user.php" class="btn btn-link">Đã có tài khoản? Đăng nhập</a>
    </form>
  </div>
</body>
</html>
