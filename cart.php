<?php include 'includes/db.php'; ?>
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
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Toy Store</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="products.php">Product</a></li>
      <li class="nav-item position-relative">
        <a class="nav-link" href="cart.php" id="cartIcon" onmouseover="showCartPreview()" onmouseout="hideCartPreview()">
          Cart 🛒
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">0</span>
        </a>
        <div id="cart-preview" class="dropdown-menu dropdown-menu-end p-3" style="width: 300px; display: none; position: absolute; right: 0; top: 100%; z-index: 999;">
          <h6 class="mb-2">Sản phẩm đã thêm</h6>
          <ul class="list-group" id="cart-items-preview">
            <!-- Sản phẩm sẽ được thêm ở đây -->
          </ul>
          <div class="mt-2 text-end">
            <a href="cart.php" class="btn btn-primary btn-sm">Xem Giỏ Hàng</a>
          </div>
        </div>
      </li>
      <li class="nav-item"><a class="nav-link" href="#">Checkout</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
    </ul>
  </div>
</nav>

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
