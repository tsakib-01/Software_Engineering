<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">

<!-- navbar_start -->

 <?php
 session_start();
  include 'db_connection.php';
include 'navbar.php';
 ?>
<!-- navbar_end -->

<!-- Main Content Layout -->
<div class="flex flex-col lg:flex-row gap-8 max-w-[1400px] mx-auto p-5">

  <!-- Sidebar -->
  <aside class="w-full lg:w-1/5 space-y-4">
    <form method="GET" action="menu.php" class="space-y-4">
      <div>
        <label class="block font-semibold">Select Category:</label>
        <select name="category" class="w-full border border-gray-300 p-2 rounded">
          <option value="">All Categories</option>
          <option value="Breakfast">Breakfast</option>
          <option value="Lunch">Lunch</option>
          <option value="Main Course">Main Course</option>
          <option value="Beverages">Beverages</option>
          <option value="Dinner">Dinner</option>
          <option value="Desserts">Desserts</option>
        </select>
      </div>
      <div>
        <label class="block font-semibold">Min Price:</label>
        <input type="number" name="min_price" placeholder="Min Price" class="w-full border border-gray-300 p-2 rounded" />
      </div>
      <div>
        <label class="block font-semibold">Max Price:</label>
        <input type="number" name="max_price" placeholder="Max Price" class="w-full border border-gray-300 p-2 rounded" />
      </div>
      <button type="submit" class="bg-orange-500 text-white py-2 rounded w-full font-semibold">Filter</button>
    </form>
  </aside>

  <!-- Product Section -->
  <main class="flex-1">
   <?php
  // Check if category is set and not empty, else default to 'All Products'
  $categoryTitle = !empty($_GET['category']) ? htmlspecialchars($_GET['category']) : 'All Products';
?>
<h1 class="text-4xl font-bold mb-6">
  <?= $categoryTitle === 'All Products' ? $categoryTitle : "$categoryTitle" ?>
</h1>

    <?php
    include 'db_connection.php';
    $conditions = ["active = 1"];
    $params = [];

    if (!empty($_GET['category'])) {
        $conditions[] = "category = ?";
        $params[] = $_GET['category'];
    }
    if (!empty($_GET['min_price'])) {
        $conditions[] = "price >= ?";
        $params[] = $_GET['min_price'];
    }
    if (!empty($_GET['max_price'])) {
        $conditions[] = "price <= ?";
        $params[] = $_GET['max_price'];
    }

    $whereClause = implode(" AND ", $conditions);
    $sql = "SELECT * FROM product_table WHERE $whereClause";
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $products = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $conn->close();
    ?>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <?php foreach ($products as $product): ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <?php if (!empty($product['productIMG'])): ?>
            <img src="data:image/jpeg;base64,<?= $product['productIMG']; ?>" alt="Product Image" class="w-full h-48 object-cover">
          <?php else: ?>
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
              <span class="text-gray-400 text-lg">No Image</span>
            </div>
          <?php endif; ?>
          <div class="p-4">
            <p class="text-gray-500 text-sm">
              <?= !empty($product['subtitles']) ? htmlspecialchars($product['subtitles']) : "No subtitle available"; ?>
            </p>
            <h2 class="text-lg font-semibold text-gray-800">
              <?= !empty($product['titles']) ? htmlspecialchars($product['titles']) : "No title available"; ?>
            </h2>
            <div class="mt-2">
              <span class="text-base font-bold text-gray-900">
                <?= !empty($product['price']) ? 'Tk. ' . number_format($product['price']) : 'Price not set'; ?>
              </span>
            </div>

             <!-- Spacer pushes button down -->
        <div class="mt-auto pt-4">
          <a href="product.php?id=<?= $product['productID']; ?>">
            <button class="bg-orange-500 text-white px-4 py-2 rounded w-full">View Product</button>
          </a>
        </div>
      </div>
    </div>
      <?php endforeach; ?>
    </div>
  </main>
</div>

<!-- Footer -->
<footer>
  <div class="bg-black px-8 py-16">
    <div class="text-red-50 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <div>
        <div class="pb-2 font-semibold">About</div>
        <div class="text-gray-400">Company</div>
        <div class="text-gray-400">Orders</div>
        <div class="text-gray-400">Quality</div>
        <div class="text-gray-400">Privacy Policy</div>
        <div class="text-gray-400">Gift Cards</div>
      </div>
      <div>
        <div class="pb-2 font-semibold">Help</div>
        <div class="text-gray-400">My Account</div>
        <div class="text-gray-400">Customer Help</div>
        <div class="text-gray-400">Contact Us</div>
        <div class="text-gray-400">Terms & Conditions</div>
        <div class="text-gray-400">FAQ</div>
      </div>
      <div>
        <div class="pb-2 font-semibold">Follow</div>
        <div class="text-gray-400">Facebook</div>
        <div class="text-gray-400">Instagram</div>
        <div class="text-gray-400">Pinterest</div>
        <div class="text-gray-400">Youtube</div>
      </div>
      <div>
        <div class="pb-2 font-semibold">Address</div>
        <div class="text-gray-400">
          BA-2/3/A (1st Floor), South Badda<br>
          (Near Sahaba Mosque via Police Plaza Bypass Road),<br>
          Hatir Jheel, Dhaka – 1212, Bangladesh.<br>
          Phone / Whatsapp: +88 01747 536594
        </div>
      </div>
    </div>
    <div class="text-white pt-14">
      <hr class="border-gray-700">
      <div class="flex justify-center text-center pt-3 text-sm">
        All Rights Reserved © Yummy.com 2025
      </div>
    </div>
  </div>
</footer>

</body>
</html>
