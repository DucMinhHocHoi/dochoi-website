<?php
session_start();
include('../../includes/db.php');

if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old = md5($_POST["old_password"]);
    $new = md5($_POST["new_password"]);
    $confirm = md5($_POST["confirm_password"]);

    // Kiểm tra mật khẩu cũ
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$old'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        if ($new === $confirm) {
            $update = "UPDATE admins SET password='$new' WHERE username='$username'";
            mysqli_query($conn, $update);
            $message = "<div class='alert alert-success'>✅ Đã đổi mật khẩu thành công!</div>";
        } else {
            $message = "<div class='alert alert-warning'>⚠️ Mật khẩu mới không khớp!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>❌ Mật khẩu cũ không đúng!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đổi mật khẩu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2 class="mb-4">🔐 Đổi mật khẩu</h2>

<?php echo $message; ?>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Mật khẩu cũ</label>
    <input type="password" name="old_password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mật khẩu mới</label>
    <input type="password" name="new_password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Xác nhận mật khẩu mới</label>
    <input type="password" name="confirm_password" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Cập nhật</button>
  <a href="index.php" class="btn btn-secondary ms-2">← Quay lại</a>
</form>

</body>
</html>
