<?php include 'includes/db.php'; ?>
<?php include 'includes/session.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Liên hệ | Cửa hàng Đồ Chơi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .form-section {
      max-width: 600px;
      margin: 60px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
  </style>
    <script>
  function toggleLogin() {
    const popup = document.getElementById("loginPopup");
    popup.classList.toggle("d-none");
  }
</script>
</head>
<body>

  <!-- Navigation -->


  <!-- Contact Form -->
  <div class="form-section">
    <h3 class="text-center mb-4">📬 Liên hệ với chúng tôi</h3>
    <form action="#" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Họ tên</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ tên">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Nội dung</label>
        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Viết lời nhắn tại đây"></textarea>
      </div>
      <button type="submit" class="btn btn-primary w-100">Gửi liên hệ</button>
    </form>
  </div>
<script>
  function toggleLogin() {
    document.getElementById("loginPopup").classList.toggle("d-none");
  }
  function toggleRegister() {
    document.getElementById("registerPopup").classList.toggle("d-none");
  }
</script>
<!-- Login Modal -->
<div id="loginPopup" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none" style="z-index:1055;">
  <div class="d-flex justify-content-center align-items-center h-100">
    <div class="bg-white p-4 rounded shadow" style="width: 320px;">
      <h5 class="mb-3 text-center">Đăng nhập</h5>
      <form id="loginForm" method="post">
        <div class="mb-2">
          <input type="text" name="username" id="loginUsername" class="form-control" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" id="loginPassword" class="form-control" required>
        </div>
        <div class="d-grid mb-2">
          <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </div>
        <div id="loginError" class="text-danger text-center mt-2" style="display: none;"></div>
        <button type="button" class="btn btn-sm btn-link text-danger w-100" onclick="toggleLogin()">Đóng</button>
      </form>
    </div>
  </div>
</div>
<script>
document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Ngăn reload form

  const username = document.getElementById("loginUsername").value;
  const password = document.getElementById("loginPassword").value;

  fetch("login-user.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Ẩn modal và reload lại trang index.php
        document.getElementById("loginPopup").classList.add("d-none");
        window.location.reload();
      } else {
        const errorDiv = document.getElementById("loginError");
        errorDiv.textContent = data.message;
        errorDiv.style.display = "block";
      }
    });
});
</script>
<!-- Register Modal -->
<div id="registerPopup" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none" style="z-index:1055;">
  <div class="d-flex justify-content-center align-items-center h-100">
    <div class="bg-white p-4 rounded shadow" style="width: 350px;">
      <h5 class="mb-3 text-center">Đăng ký tài khoản</h5>
      <form id="registerForm">
        <div id="registerMessage" class="text-success text-center mt-3"></div>
        <div class="mb-2">
          <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
        </div>
        <div class="mb-2">
          <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
        </div>
        <div class="mb-2">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-2">
          <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
        </div>
        <div class="mb-3">
          <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu" required>
        </div>
        <div class="d-grid mb-2">
          <button type="submit" class="btn btn-primary">Đăng ký</button>
        </div>
        <button type="button" class="btn btn-sm btn-link text-danger w-100" onclick="toggleRegister()">Đóng</button>
      </form>
    </div>
  </div>
</div>
<script>
document.getElementById("registerForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("register-user.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    // Hiển thị thông báo kết quả
    document.getElementById("registerMessage").innerHTML = data;

    // Reset form (nếu muốn)
    this.reset();

    // Tự động ẩn popup sau 3s (nếu muốn)
    // setTimeout(() => toggleRegister(), 3000);
  });
});
</script>
</body>
</html>
