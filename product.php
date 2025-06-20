<?php include 'includes/db.php'; ?>
<?php include 'includes/session.php'; ?>
<?php include 'header.php'; ?>
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
  <script>
  function toggleLogin() {
    const popup = document.getElementById("loginPopup");
    popup.classList.toggle("d-none");
  }
</script>
<body>

<!-- Navigation -->


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
