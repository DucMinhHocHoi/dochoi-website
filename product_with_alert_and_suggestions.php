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
</script>


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
      <button class="btn btn-success" onclick='addToCart({
  id: <?= $product["id"] ?>,
  name: "<?= addslashes($product["name"]) ?>",
  price: <?= $product["price"] ?>,
  image: "<?= $product["image"] ?>"
})'>Add to Cart</button>

    </div>
  </div>
</div>

<!-- Suggested Products -->
<div class="container py-5">
  <h3 class="text-center mb-4">You Might Also Like</h3>
  <div class="row g-4">
    <?php
    $suggest = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 4");
    while($s = $suggest->fetch_assoc()): ?>
      <div class="col-md-3">
        <div class="card product-card">
          <a href="product.php?id=<?= $s['id'] ?>">
            <img src="<?= $s['image'] ?>" class="card-img-top" alt="<?= $s['name'] ?>">
          </a>
          <div class="card-body text-center">
            <h5><?= $s['name'] ?></h5>
            <p class="text-primary fw-bold">$<?= $s['price'] ?></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>


<!-- Sản phẩm có thể bạn thích -->
<div class="container py-5">
  <h3 class="text-center mb-4">Sản phẩm có thể bạn thích</h3>
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

function updateCartUI() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartCount = document.getElementById("cart-count");
  const cartPreview = document.getElementById("cart-items-preview");

  if (cartCount) cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
  if (cartPreview) {
    cartPreview.innerHTML = cart.map(item => `
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <img src="${item.image}" width="40"> ${item.name}
        <span class="badge bg-secondary">$${item.price} x ${item.quantity}</span>
      </li>
    `).join('');
  }
}
</script>
<script>
function showCartPreview() {
  document.getElementById("cart-preview").style.display = "block";
}
function hideCartPreview() {
  document.getElementById("cart-preview").style.display = "none";
}
document.addEventListener("DOMContentLoaded", updateCartUI);
</script>
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
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartUI() {
  const cartCount = document.getElementById("cart-count");
  const cartPreview = document.getElementById("cart-items-preview");
  cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);

  if (cartPreview) {
    cartPreview.innerHTML = cart.map((item, index) => `
      <div class="list-group-item d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <img src="${item.image}" width="50" height="50" class="me-2">
          <div>
            <div>${item.name}</div>
            <div class="d-flex align-items-center mt-1">
              <button class="btn btn-sm btn-outline-dark fw-bold me-1" onclick="updateQuantity(${index}, -1)">−</button>
              <span>${item.quantity}</span>
              <button class="btn btn-sm btn-outline-dark fw-bold ms-1" onclick="updateQuantity(${index}, 1)">+</button>
            </div>
          </div>
        </div>
        <div>
          <span class="badge bg-secondary me-2">$${item.price}</span>
          <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">×</button>
        </div>
      </div>
    `).join('');
  }
}

function updateQuantity(index, change) {
  cart[index].quantity += change;
  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
}

function removeItem(index) {
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
}

let cartHideTimeout;
function showCartPreview() {
  clearTimeout(cartHideTimeout);
  document.getElementById("cart-preview").style.display = "block";
}
function hideCartPreview() {
  cartHideTimeout = setTimeout(() => {
    document.getElementById("cart-preview").style.display = "none";
  }, 400);
}
function cancelHideCart() {
  clearTimeout(cartHideTimeout);
}

document.addEventListener("DOMContentLoaded", updateCartUI);
</script>


<script>
function addToCartFromDetail() {
  const product = {
    id: <?= $product['id'] ?>,
    name: "<?= $product['name'] ?>",
    price: <?= $product['price'] ?>,
    image: "<?= $product['image'] ?>"
  };

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

  alert(`Đã thêm "${product.name}" vào giỏ hàng!`);
}
</script>

</body>
</html>