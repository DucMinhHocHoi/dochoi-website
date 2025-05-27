<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = $_POST['customer_name'];
    $product = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total = $quantity * $price;
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO orders (customer_name, product_name, quantity, total_price, order_date)
            VALUES ('$customer', '$product', $quantity, $total, '$date')";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Đặt hàng thành công!";
        // header("Location: success.php"); exit; // hoặc chuyển trang nếu cần
    } else {
        echo "❌ Lỗi: " . mysqli_error($conn);
    }
}
?>
