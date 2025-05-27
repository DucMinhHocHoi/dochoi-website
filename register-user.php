<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Chuẩn bị truy vấn dùng prepared statement
    $stmt = $conn->prepare("INSERT INTO customers (name, username, email, password, created_at)
                            VALUES (?, ?, ?, ?, NOW())");

    $stmt->bind_param("ssss", $name, $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Đăng ký thành công!</div>";
    } else {
        echo "Lỗi đăng ký: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
