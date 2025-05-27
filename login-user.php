<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sai mật khẩu.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Tài khoản không tồn tại.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
  <div class="container">
    <h2 class="mb-3">Đăng nhập khách hàng</h2>
    <?php if (!empty($message)): ?>
  <div class="alert alert-danger"><?= $message ?></div>
<?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" required class="form-control">
      </div>
      <div class="mb-3">
        <label>Mật khẩu:</label>
        <input type="password" name="password" required class="form-control">
      </div>
      <button class="btn btn-primary">Đăng nhập</button>
      <a href="register.php" class="btn btn-link">Chưa có tài khoản? Đăng ký</a>
    </form>
  </div>
</body>
</html>
