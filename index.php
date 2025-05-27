<?php include 'includes/db.php'; ?>
<?php include 'includes/session.php'; ?>
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
    footer p, footer a {
      margin: 5px 0;
      color: white;
    }
    footer a:hover {
      text-decoration: underline;
    }
  .btn-outline-primary {
  border-width: 2px;
  font-weight: 500;
    }
  #loginPopup .form-control,
#registerPopup .form-control {
  font-size: 0.95rem;
}
@media (max-width: 1200px) {
  nav .navbar-nav {
    flex-wrap: wrap;
  }

  form.d-flex {
    flex-wrap: nowrap;
    max-width: 300px;
  }

  form.d-flex input {
    flex: 1;
  }
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
<?php include 'header.php'; ?>

<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="display-5 fw-bold">Toys for children and adults</h1>
        <a href="#" class="btn btn-primary mt-3">Shop Now</a>
      </div>
      <div class="col-md-6">
        <img src="assets/images/banner-toy.jpg" alt="Banner Toy" class="img-fluid">
      </div>
    </div>
  </div>
</section>

<!-- Featured Products -->
<section class="py-5">
  <div id="carouselFeatured" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <h2 class="text-center mb-4">Featured Products</h2>
    <?php
    $result = $conn->query("SELECT * FROM products WHERE category = 'featured'");
    $count = 0;
    $active = true;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 === 0) {
            if ($count > 0) echo '</div></div>'; // đóng item cũ
            echo '<div class="carousel-item'.($active ? ' active' : '').'"><div class="row">';
            $active = false;
        }
    ?>
        <div class="col-md-3">
          <a href="product.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
            <div class="card product-card">
              <img src="<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?= $row['name'] ?></h5>
                <p class="card-text fw-bold">$<?= $row['price'] ?></p>
              </div>
            </div>
          </a>
        </div>
    <?php
        $count++;
    }
    if ($count > 0) echo '</div></div>'; // đóng cuối cùng
    ?>
  </div>
  <!-- Nút điều hướng -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselFeatured" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselFeatured" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
</section>

<!-- Related Toys -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Related Toys</h2>
    <div class="row g-4">
      <?php
      $result = $conn->query("SELECT * FROM products WHERE category = 'related'");
      while($row = $result->fetch_assoc()): ?>
        <div class="col-md-3">
          <a href="product.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
            <div class="card product-card">
              <img src="<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?= $row['name'] ?></h5>
                <p class="card-text fw-bold">$<?= $row['price'] ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Best Sellers -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Best Sellers</h2>
    <div class="row g-4">
      <?php
      $result = $conn->query("SELECT * FROM products WHERE category = 'bestseller'");
      while($row = $result->fetch_assoc()): ?>
        <div class="col-md-3">
          <a href="product.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
            <div class="card product-card">
              <img src="<?= $row['image'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?= $row['name'] ?></h5>
                <p class="card-text fw-bold">$<?= $row['price'] ?></p>
              </div>
            </div>
          </a>
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