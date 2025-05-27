<?php include 'includes/db.php'; ?>
<?php include 'includes/session.php'; ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Toy Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
  <script>
  function toggleLogin() {
    const popup = document.getElementById("loginPopup");
    popup.classList.toggle("d-none");
  }
</script>
<body>
  
<div class="container py-5">
  <h2 class="mb-4">📦 Thông Tin Đặt Hàng</h2>

  <form action="process_order.php" method="POST" onsubmit="return submitOrder()">
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Họ và tên</label>
        <input type="text" name="customer_name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="customer_phone" class="form-control" required>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Địa chỉ giao hàng</label>
      <textarea name="customer_address" class="form-control" rows="3" required></textarea>
    </div>

    <h4 class="mt-5">🛒 Giỏ Hàng Của Bạn</h4>
    <table class="table mt-3" id="cart-table">
      <thead>
        <tr>
          <th>Sản phẩm</th>
          <th>Số lượng</th>
          <th>Giá</th>
          <th>Tổng</th>
        </tr>
      </thead>
      <tbody>
        <!-- Dữ liệu giỏ hàng sẽ hiển thị bằng JavaScript -->
      </tbody>
    </table>

    <div class="text-end">
      <button type="submit" class="btn btn-success">Đặt Hàng</button>
    </div>
  </form>
</div>

<script>
const cart = JSON.parse(localStorage.getItem("cart")) || [];

function renderCart() {
  const tableBody = document.querySelector("#cart-table tbody");
  let html = '';
  let total = 0;

  cart.forEach(item => {
    const line = item.price * item.quantity;
    total += line;
    html += `
      <tr>
        <td>${item.name}<input type="hidden" name="items[]" value="${item.id}|${item.quantity}"></td>
        <td>${item.quantity}</td>
        <td>$${item.price}</td>
        <td>$${line.toFixed(2)}</td>
      </tr>
    `;
  });

  if (cart.length === 0) {
    html = '<tr><td colspan="4" class="text-center text-muted">Giỏ hàng của bạn đang trống.</td></tr>';
  } else {
    html += `<tr><td colspan="3" class="text-end fw-bold">Tổng cộng:</td><td><strong>$${total.toFixed(2)}</strong></td></tr>`;
  }

  tableBody.innerHTML = html;
}

function submitOrder() {
  if (cart.length === 0) {
    alert("Giỏ hàng đang trống!");
    return false;
  }
  return true;
}

document.addEventListener("DOMContentLoaded", renderCart);
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
</body>
<script>
function submitOrder() {
  const cart = JSON.parse(localStorage.getItem("cart") || "[]");
  if (cart.length === 0) {
    alert("Giỏ hàng đang trống!");
    return;
  }

  const form = document.getElementById("checkout-form");
  const hidden = document.createElement("input");
  hidden.type = "hidden";
  hidden.name = "cart";
  hidden.value = JSON.stringify(cart);
  form.appendChild(hidden);
  form.submit();
}
</script>

</html>
