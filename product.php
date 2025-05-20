<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Detail</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .product-detail img {
      max-width: 100%;
      height: auto;
    }
    .product-card img {
      height: 200px;
      object-fit: contain;
    }
    #cart-preview:hover, #cartIcon:hover + #cart-preview, #cartIcon:hover {
      display: block !important;
    }
    .cart-button-group button {
      border: none;
      background: #e9ecef;
      width: 32px;
      height: 32px;
      font-weight: bold;
      border-radius: 4px;
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
        <a class="nav-link" href="cart.php" id="cartIcon">
          Cart 🛒<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">0</span>
        </a>
        <div id="cart-preview" class="dropdown-menu dropdown-menu-end p-3 shadow" style="width: 350px; display: none; position: absolute; right: 0; top: 100%; z-index: 999;">
          <h6 class="mb-3"><i class="bi bi-cart4"></i> Sản phẩm đã thêm</h6>
          <ul class="list-group mb-2" id="cart-items-preview" style="max-height: 250px; overflow-y: auto;"></ul>
          <div class="text-end mt-2">
            <a href="cart.php" class="btn btn-primary btn-sm">Xem Giỏ Hàng</a>
          </div>
        </div>
      </li>
      <li class="nav-item"><a class="nav-link" href="#">Checkout</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
    </ul>
  </div>
</nav>

<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $result = $conn->query("SELECT * FROM products WHERE id = $id");
  $product = $result->fetch_assoc();
}
?>

<div class="container py-5 product-detail">
  <div class="row">
    <div class="col-md-6">
      <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
    </div>
    <div class="col-md-6">
      <h2><?= $product['name'] ?></h2>
      <h4 class="text-danger">$<?= $product['price'] ?></h4>
      <p><strong>Category:</strong> <?= ucfirst($product['category']) ?></p>
      <p>This is a great toy for children and families to enjoy. Add to cart now and bring joy to your home!</p>
      <button onclick='addToCart(<?= json_encode($product) ?>)' class="btn btn-success">Add to Cart</button>
    </div>
  </div>
</div>
<!-- Sản phẩm có thể bạn thích -->
<div class="container py-5">
  <h3 class="text-center mb-4">Products you might like</h3>
  <div class="row g-4">
    <?php
    $suggested = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 4");
    while($s = $suggested->fetch_assoc()): ?>
      <div class="col-md-3">
        <a href="product.php?id=<?= $s['id'] ?>" class="text-decoration-none text-dark">
          <div class="card product-card">
            <img src="<?= $s['image'] ?>" class="card-img-top" alt="<?= $s['name'] ?>">
            <div class="card-body text-center">
              <h5 class="card-title"><?= $s['name'] ?></h5>
              <p class="card-text fw-bold">$<?= $s['price'] ?></p>
            </div>
          </div>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartUI() {
  const cartCount = document.getElementById("cart-count");
  const cartPreview = document.getElementById("cart-items-preview");

  cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartPreview.innerHTML = cart.map((item, i) => `
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <img src="${item.image}" width="40">
      <div class="flex-grow-1 mx-2">
        ${item.name}
        <div class="cart-button-group mt-1">
          <button onclick="changeQty(${i}, -1)">-</button>
          <span class="mx-2">${item.quantity}</span>
          <button onclick="changeQty(${i}, 1)">+</button>
        </div>
      </div>
      <span class="badge bg-secondary">$${item.price}</span>
      <button onclick="removeFromCart(${i})" class="btn btn-sm btn-danger ms-2">&times;</button>
    </li>
  `).join('');
}

function addToCart(product) {
  let found = cart.find(p => p.id === product.id);
  if (found) {
    found.quantity++;
  } else {
    cart.push({...product, quantity: 1});
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
  showToast("✅ Đã thêm vào giỏ hàng!");
}
function showToast(message) {
  const toast = document.getElementById("cart-toast");
  toast.textContent = message;
  toast.style.display = "block";
  setTimeout(() => {
    toast.style.display = "none";
  }, 2500);
}

function changeQty(index, delta) {
  if (!cart[index]) return;
  cart[index].quantity += delta;
  if (cart[index].quantity <= 0) cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
}

function removeFromCart(index) {
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
}

document.addEventListener("DOMContentLoaded", updateCartUI);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div id="cart-toast" style="position: fixed; top: 80px; right: 30px; z-index: 9999; display: none;" class="alert alert-success shadow">
  ✅ Đã thêm vào giỏ hàng!
</div>
</body>
</html>
