
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
  <div class="container-fluid d-flex justify-content-between align-items-center flex-nowrap">

    <a class="navbar-brand fw-bold text-warning" href="index.php">Toy Store</a>

    <ul class="navbar-nav me-3 d-flex flex-row flex-nowrap">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="products.php">Product</a></li>
      <li class="nav-item"><a class="nav-link" href="carts.php">Cart 🛒</a></li>
      <li class="nav-item"><a class="nav-link" href="checkout.php">Checkout</a></li>
      <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
    </ul>

    <form class="d-flex me-3" method="GET" action="products.php" style="max-width: 400px;">
      <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Tìm sản phẩm..." required>
      <button class="btn btn-sm btn-primary" type="submit">Tìm kiếm</button>
    </form>

    <!-- Thông tin người dùng -->
    <div class="d-flex align-items-center flex-nowrap">
      <?php if (isset($_SESSION['user_loggedin'])): ?>
        <span class="me-3">🔥 Xin chào, <strong><?= $_SESSION['username'] ?></strong></span>
        <a href="logout-user.php" class="btn btn-sm btn-outline-danger">Đăng xuất</a>
      <?php else: ?>
        <button class="btn btn-sm btn-outline-primary me-2" onclick="toggleLogin()">Login</button>
        <button class="btn btn-sm btn-outline-success" onclick="toggleRegister()">Register</button>
      <?php endif; ?>
    </div>

  </div>
</nav>