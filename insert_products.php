<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'dochoi';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$categories = ['featured', 'related', 'bestseller'];
$toyNames = ['Toy Car', 'Building Set', 'Stuffed Animal', 'Color Blocks', 'Mini Piano', 'Toy Helicopter', 'Puzzle Board', 'Drawing Pad', 'Water Gun', 'Toy Guitar'];
$images = [
  'car.jpg', 'blocks.jpg', 'stuffed.jpg', 'colorblocks.jpg', 'piano.jpg',
  'helicopter.jpg', 'puzzle.jpg', 'drawingpad.jpg', 'watergun.jpg', 'guitar.jpg'
];

for ($i = 0; $i < 20; $i++) {
  $name = $toyNames[array_rand($toyNames)] . ' #' . rand(100, 999);
  $price = number_format(rand(999, 4999) / 100, 2);
  $image = 'assets/images/' . $images[array_rand($images)];
  $category = $categories[array_rand($categories)];

  $sql = "INSERT INTO products (name, price, image, category)
          VALUES ('$name', '$price', '$image', '$category')";
  $conn->query($sql);
}

echo "Đã thêm 20 sản phẩm giả lập!";
$conn->close();
?>