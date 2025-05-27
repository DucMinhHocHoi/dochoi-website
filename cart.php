<?php include 'includes/db.php'; ?>
<?php include 'includes/session.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Toy Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .hero {
      background-color: #f8f9fa;
      padding: 50px 0;
      text-align: center;
    }
    .hero img {
      max-width: 300px;
    }
    .product-card img {
      height: 200px;
      object-fit: contain;
    }
    footer {
      background-color: #f8f9fa;
      padding: 30px 0;
      text-align: left;
      margin-top: 50px;
      background-image: url('assets/images/footer-banner.jpg');
      background-size: cover;
      background-position: left;
      color: white;
    }
    footer p {
      margin: 5px 0;
      color: white;
    }
    footer p, footer a {
      margin: 5px 0;
      color: white;
    }
    footer a:hover {
      text-decoration: underline;
    }
    a.text-decoration-none:hover {
      text-decoration: none;
    }
  </style>
</head>
  <script>
  function toggleLogin() {
    const popup = document.getElementById("loginPopup");
    popup.classList.toggle("d-none");
  }
</script>
<body>

<!-- Navigation -->


<script>
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartUI() {
  const cartCount = document.getElementById("cart-count");
  const cartPreview = document.getElementById("cart-items-preview");

  cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartPreview.innerHTML = cart.map(item => `
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <img src="${item.image}" width="40"> ${item.name}
      <span class="badge bg-secondary">$${item.price} x ${item.quantity}</span>
    </li>
  `).join('');
}

function showCartPreview() {
  document.getElementById("cart-preview").style.display = "block";
}

function hideCartPreview() {
  document.getElementById("cart-preview").style.display = "none";
}

document.addEventListener("DOMContentLoaded", updateCartUI);

function addToCart(product) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const existing = cart.find(item => item.id === product.id);
  if (existing) {
    existing.quantity += 1;
  } else {
    product.quantity = 1;
    cart.push(product);
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
  alert(`Đã thêm ${product.name} vào giỏ hàng!`);
}
</script>
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
