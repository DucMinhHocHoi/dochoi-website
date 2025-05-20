<?php include 'includes/db.php'; ?>
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
<body>


<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Toy Store</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="products.php">Product</a></li>
      <li class="nav-item position-relative" onmouseover="showCartPreview()" onmouseout="hideCartPreview()">
        <a class="nav-link" href="cart.php" id="cartIcon">
          Cart 🛒
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">0</span>
        </a>
        <div id="cart-preview" class="dropdown-menu dropdown-menu-end p-3 shadow" style="width: 340px; display: none; position: absolute; right: 0; top: 100%; z-index: 999;">
          <h6 class="mb-3">🛒 Sản phẩm đã thêm</h6>
          <div id="cart-items-preview" class="list-group" style="max-height: 250px; overflow-y: auto;"></div>
          <div class="text-end mt-3">
            <a href="cart.php" class="btn btn-primary btn-sm">Xem Giỏ Hàng</a>
          </div>
        </div>
      </li>
      <li class="nav-item"><a class="nav-link" href="#">Checkout</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
    </ul>
  </div>
</nav>
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
</body>
</html>
