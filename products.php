<?php include 'includes/db.php';
include 'includes/session.php';
include 'header.php';
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $search);
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Products - Toy Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
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
    footer p, footer a {
      margin: 5px 0;
      color: white;
    }
    footer a:hover {
      text-decoration: underline;
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

  <!-- Tìm kiếm -->
  <div class="col-md-4">
    <input type="text" name="search" class="form-control" placeholder="Tìm sản phẩm..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  </div>

  <!-- Sắp xếp -->
  <div class="col-md-3">
    <select name="sort" class="form-select">
      <option value="">Sắp xếp theo</option>
      <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'selected' : '' ?>>Giá tăng dần</option>
      <option value="desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'selected' : '' ?>>Giá giảm dần</option>
    </select>
  </div>

  <!-- Nút lọc -->
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-100">Lọc</button>
  </div>
</form>
<!-- All Products -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">All Products</h2>
    <div class="row g-4">
      <?php
      $result = $conn->query("SELECT * FROM products");
      while($row = $result->fetch_assoc()): ?>
        <div class="col-md-3">
          <div class="card product-card h-100">
            <a href="product.php?id=<?= $row['id'] ?>">
              <img src="<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
            </a>
            <div class="card-body text-center">
              <h5 class="card-title"><?= $row['name'] ?></h5>
              <p class="card-text fw-bold text-primary">$<?= $row['price'] ?></p>
              <a href="product.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="container">
    <p><strong>Địa chỉ:</strong> 123 Trần Phú, Hà Nội</p>
    <p><strong>Facebook:</strong> <a href="https://facebook.com" target="_blank">facebook.com/yourprofile</a></p>
    <p><strong>Email:</strong> lienhe@dochoi.vn</p>
    <p><strong>Hotline:</strong> 0901 234 567</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartUI() {
  const cartCount = document.getElementById("cart-count");
  const cartPreview = document.getElementById("cart-items-preview");
  cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);

  cartPreview.innerHTML = cart.map((item, index) => `
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <img src="${item.image}" width="40" class="me-2">
        <span>${item.name}</span>
      </div>
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-dark fw-bold btn-sm btn-decrease" data-index="${index}">−</button>
        <span class="mx-2">${item.quantity}</span>
        <button class="btn btn-outline-dark fw-bold btn-sm btn-increase" data-index="${index}">+</button>
        <span class="badge bg-secondary ms-2">$${item.price}</span>
        <button class="btn btn-danger btn-sm btn-remove ms-2" data-index="${index}">✕</button>
      </div>
    </li>
  `).join('');

  attachCartEventListeners();
  localStorage.setItem("cart", JSON.stringify(cart));
}

function attachCartEventListeners() {
  document.querySelectorAll('.btn-increase').forEach(btn =>
    btn.onclick = e => {
      const i = +e.target.dataset.index;
      cart[i].quantity += 1;
      updateCartUI();
    }
  );

  document.querySelectorAll('.btn-decrease').forEach(btn =>
    btn.onclick = e => {
      const i = +e.target.dataset.index;
      if (cart[i].quantity > 1) cart[i].quantity -= 1;
      else cart.splice(i, 1);
      updateCartUI();
    }
  );

  document.querySelectorAll('.btn-remove').forEach(btn =>
    btn.onclick = e => {
      const i = +e.target.dataset.index;
      cart.splice(i, 1);
      updateCartUI();
    }
  );
}

function showCartPreview() {
  document.getElementById("cart-preview").style.display = "block";
}

function hideCartPreview() {
  setTimeout(() => {
    const cartPreview = document.getElementById("cart-preview");
    if (!cartPreview.matches(':hover')) {
      cartPreview.style.display = "none";
    }
  }, 300);
}

document.addEventListener("DOMContentLoaded", () => {
  updateCartUI();
  const preview = document.getElementById("cart-preview");
  preview.addEventListener("mouseover", () => preview.style.display = "block");
  preview.addEventListener("mouseleave", () => preview.style.display = "none");
});
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
</html>
