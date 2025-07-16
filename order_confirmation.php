<?php
// Fetch order details based on the order_id from query string
$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petstore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query for order details
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="container mx-auto py-10 px-6">
    <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Order Confirmation</h2>

    <div class="bg-white p-6 rounded-lg shadow-lg">
      <p class="text-xl font-semibold text-gray-700">Order ID: <?php echo $order['order_id']; ?></p>
      <p class="text-xl font-semibold text-gray-700">Email: <?php echo htmlspecialchars($order['email']); ?></p>
      <p class="text-xl font-semibold text-gray-700">Total Price: <?php echo number_format($order['total_price'], 2); ?> Tk.</p>
      <p class="text-xl font-semibold text-gray-700">Shipping Address: <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
      <p class="text-xl font-semibold text-gray-700">Order Status: <?php echo htmlspecialchars($order['status']); ?></p>
    </div>
  </div>
</body>
</html>
