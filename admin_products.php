<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $popular = isset($_POST['popular']) ? 1 : 0;
    $latest = isset($_POST['latest']) ? 1 : 0;
    $active = 1;

    // Image 1
    $productIMG = null;
    if (isset($_FILES['productIMG']) && $_FILES['productIMG']['error'] === 0) {
        $img_tmp = $_FILES['productIMG']['tmp_name'];
        $img_data = file_get_contents($img_tmp);
        $productIMG = base64_encode($img_data);
    }

    // Image 2
    $productIMG_2 = null;
    if (isset($_FILES['productIMG_2']) && $_FILES['productIMG_2']['error'] === 0) {
        $img_tmp = $_FILES['productIMG_2']['tmp_name'];
        $img_data = file_get_contents($img_tmp);
        $productIMG_2 = base64_encode($img_data);
    }

    // Image 3
    $productIMG_3 = null;
    if (isset($_FILES['productIMG_3']) && $_FILES['productIMG_3']['error'] === 0) {
        $img_tmp = $_FILES['productIMG_3']['tmp_name'];
        $img_data = file_get_contents($img_tmp);
        $productIMG_3 = base64_encode($img_data);
    }

    // Inserting
    $sql = "INSERT INTO `product_table` 
        (titles, subtitles, price, discount, quantity, description, productIMG, productIMG_2, productIMG_3, category, popular, latest) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssddisssssii', $title, $subtitle, $price, $discount, $quantity, $description, $productIMG, $productIMG_2, $productIMG_3, $category, $popular, $latest);

    if ($stmt->execute()) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>


<?php
include 'db_connection.php';

// Fetch data from the database
$sql = "SELECT * FROM product_table";

$result = $conn->query($sql);

// Store the results in an array
$products = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();
?>

<?php
include('db_connection.php');

// Fetch the settings from the database
$sql = "SELECT address, logo, avatar FROM settings_table LIMIT 1";
$result = $conn->query($sql);

// Initialize variables
$address = '';
$logo = '';
$avatar = '';

// Check if there's a row fetched
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $address = $row['address'];
    $logo = $row['logo'];
    $avatar = $row['avatar'];
} else {
    echo "No settings found.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventory - Responsive Sidebar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }

    document.addEventListener("click", function (e) {
      const btn = document.getElementById("filterButton");
      const menu = document.getElementById("filterMenu");
      if (!btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add("hidden");
      }
    });
  </script>
</head>

<body class="bg-gray-100 min-h-screen flex">

  <!-- Mobile Menu Button -->
  <div class="md:hidden fixed top-4 left-4 z-50">
    <button onclick="toggleSidebar()" class="text-purple-700 bg-white p-2 rounded shadow">
      <i class="fas fa-bars text-xl"></i>
    </button>
  </div>



  <!-- Sidebar -->
 <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 bg-white border-r h-screen p-4 shadow-md overflow-y-auto">
<h1 class="text-xl font-extrabold text-purple-700 mb-6 tracking-wide">Dashboard</h1>
    <nav class="space-y-4 text-sm">
      
          <a href="admin.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
  <i class="fas fa-home mr-2 text-purple-600 text-base"></i> Dashboard
      </a>
 <a href="admin_products.php" class="flex items-center px-2 py-1 rounded-lg bg-purple-100 text-purple-700 font-semibold transition">
 <i class="fas fa-box-open mr-2 text-purple-600 text-sm"></i> Inventory
</a>

      <a href="admin_customers.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
        <i class="fas fa-users mr-2 text-purple-600 text-sm"></i> Customers
      </a>

      <div class="mt-4">
    <a href="admin_orders.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
  

      <p class="flex items-center px-2 py-1 text-gray-800 font-semibold uppercase tracking-wide text-xs">
          
      <i class="fas fa-shopping-cart mr-2 text-purple-600 text-sm"></i> Orders
        </p>
        </a>
          <!-- </a>
        <ul class="ml-5 mt-1 space-y-1 text-xs">
          <a href="order-list.html">
            <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Order List</li>
          </a>
          <a href="pending-orders.html">
            <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Pending Orders</li>
          </a>
          <a href="delivering-orders.html">
            <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Delivering Orders</li>
          </a>
          <a href="delivered-orders.html">
            <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Delivered Orders</li>
          </a>
          <a href="completed-orders.html">
            <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Completed Orders</li>
          </a>
          <a href="cancelled-orders.html">
            <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Cancelled Orders</li>
          </a>
        </ul> -->
      </div>
<!-- 
      <style>
        *{
          outline: 2px solid red;;
        } 
      </style> -->

      <div class="space-y-2 border-t pt-3 mt-3">
      <a href="admin_booking.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition"> <i class="fas fa-calendar-check mr-2 text-purple-600 text-sm"></i> Bookings

        </a>
        <a href="admin_comments.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
          <i class="fas fa-bell mr-2 text-purple-600 text-sm"></i> Notifications
        </a>
        <a href="admin_settings.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
          <i class="fas fa-cog mr-2 text-purple-600 text-sm"></i> Settings
        </a>
      </div>
    </nav>
    <a href="login.php">
    <button class="mt-6 flex items-center text-red-500 hover:text-red-600 text-xs px-2 py-1 transition">
      <i class="fas fa-sign-out-alt mr-2 text-sm"></i> Log out
    </button></a>
  </aside>




    <!-- Main Content -->
    <div class="w-full md:w-10/12 p-4 md:p-8 ml-64">

        <!-- Logout Button -->
     
<div class="container mx-auto px-4 py-6">

  <!-- Top Action Bar -->
<div class="flex flex-wrap justify-between items-center mb-6">
  <!-- Title -->
  <h2 class="text-2xl font-bold text-gray-800">Inventory</h2>

  <!-- Buttons -->
  <div class="flex gap-3 mt-3 md:mt-0">
<?php
include 'db_connection.php';
$query = "SELECT DISTINCT category FROM product_table";
$result = mysqli_query($conn, $query);
?>

<div class="relative inline-block text-left">
  <!-- Toggle Button -->
  <button onclick="toggleDropdown()" class="flex items-center bg-white text-purple-700 border border-purple-600 px-4 py-2 rounded-md hover:bg-purple-50 transition text-sm font-medium">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 8v6l-2 2v-8L3 6V4z" />
    </svg>
    Filter
  </button>

  <!-- Dropdown Menu -->
  <div id="dropdownMenu" class="absolute mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 hidden">
    <div class="py-1">
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <a href="?category=<?php echo urlencode($row['category']); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-100 hover:text-purple-700">
          <?php echo htmlspecialchars($row['category']); ?>
        </a>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<script>
  function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
  }

  // Optional: Close dropdown if clicked outside
  document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdownMenu');
    const button = event.target.closest('button');

    if (!dropdown.contains(event.target) && !button) {
      dropdown.classList.add('hidden');
    }
  });
</script>


  <a href="admin_products.php" class="bg-white text-gray-800 border border-gray-300 px-4 py-2 rounded-md hover:bg-gray-100 transition text-sm font-medium">
  See All
</a>

  <button onclick="openModal()" class="bg-purple-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
    Add Product +
</button>

  </div>
</div>
<?php
include 'db_connection.php';

// Get category from URL if selected
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

if (!empty($selectedCategory)) {
    $stmt = $conn->prepare("SELECT * FROM product_table WHERE category = ?");
    $stmt->bind_param("s", $selectedCategory);
} else {
    $stmt = $conn->prepare("SELECT * FROM product_table");
}


$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>


<div class="overflow-x-auto mt-6">
    <table class="min-w-full bg-white rounded-lg shadow text-sm">
        <thead>
            <tr class="bg-purple-600 text-white text-left">
                <th class="p-3">Image</th>
                <th class="p-3">Product Name</th>
                <th class="p-3">Category</th>
                <th class="p-3">Price</th>
                <th class="p-3">Stock</th>
                <th class="p-3">Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <!-- Image -->
                <td class="p-3">
    <div class="flex space-x-1">
        <?php
        $images = ['productIMG', 'productIMG_2', 'productIMG_3'];
        $hasImage = false;
        foreach ($images as $imgField):
            if (!empty($product[$imgField])):
                $hasImage = true;
        ?>
            <img src="data:image/jpeg;base64,<?= $product[$imgField]; ?>" class="h-12 w-12 object-cover rounded" alt="Product Image">
        <?php
            endif;
        endforeach;
        if (!$hasImage):
        ?>
            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No Image</div>
        <?php endif; ?>
    </div>
</td>


                    <!-- Name -->
                    <td class="p-3 font-semibold text-gray-800">
                        <?= htmlspecialchars($product['titles']) ?>
                        <div class="text-xs text-gray-500"><?= htmlspecialchars($product['subtitles']) ?></div>
                    </td>

                    <!-- Category -->
                    <td class="p-3 text-gray-700"><?= htmlspecialchars($product['category']) ?></td>

                    <!-- Price -->
                    <td class="p-3 text-gray-800 font-medium">
                        <?= !empty($product['price']) ? 'Tk. ' . number_format($product['price']) : '-' ?>
                    </td>

                    <!-- Stock -->
                    <td class="p-3"><?= number_format($product['quantity']) ?></td>

                    <!-- Status -->
                    <td class="p-3">
                        <?php if ($product['active'] == 1): ?>
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Inactive</span>
                        <?php endif; ?>
                    </td>

                    <!-- Action Buttons -->
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a href="#" class="text-blue-600 hover:underline text-xs edit-btn"
                               data-id="<?= $product['productID']; ?>"
                               data-title="<?= htmlspecialchars($product['titles']); ?>"
                               data-subtitle="<?= htmlspecialchars($product['subtitles']); ?>"
                               data-price="<?= $product['price']; ?>"
                               data-discount="<?= $product['discount']; ?>"
                               data-quantity="<?= $product['quantity']; ?>"
                               data-description="<?= htmlspecialchars($product['description']); ?>"
                               data-category="<?= htmlspecialchars($product['category']); ?>"
                               data-popular="<?= $product['popular']; ?>"
                               data-latest="<?= $product['latest']; ?>">
                               Edit
                            </a>

                            <?php if ($product['active'] == 1): ?>
                                <a href="toggle_active.php?productID=<?= $product['productID']; ?>&active=0"
                                   class="text-red-600 hover:underline text-xs">Inactivate</a>
                            <?php else: ?>
                                <a href="toggle_active.php?productID=<?= $product['productID']; ?>&active=1"
                                   class="text-green-600 hover:underline text-xs">Activate</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>




<!-- Modal Overlay -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
        <!-- Close Button -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-600 hover:text-red-600 text-xl">&times;</button>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Add New Product</h2>

       <form action="admin_products.php" method="POST" enctype="multipart/form-data">
    <div class="flex gap-4 mt-4">
        <!-- Title -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" required class="w-full p-2 border rounded">
        </div>

        <!-- Subtitle -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Subtitle</label>
            <input type="text" name="subtitle" required class="w-full p-2 border rounded">
        </div>
    </div>

    <!-- Description -->
    <label class="block mt-4 text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" required class="w-full p-2 border rounded"></textarea>

    <div class="flex gap-4 mt-4">
        <!-- Price -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" name="price" required class="w-full p-2 border rounded">
        </div>

        <!-- Discount -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Discount</label>
            <input type="number" name="discount" required class="w-full p-2 border rounded">
        </div>
    </div>

    <div class="flex gap-4 mt-4">
        <!-- Quantity -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" required class="w-full p-2 border rounded">
        </div>

        <!-- Product Image 1 -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Product Image 1</label>
            <input type="file" name="productIMG" class="w-full p-2 border rounded">
        </div>
    </div>

    <div class="flex gap-4 mt-4">
        <!-- Product Image 2 -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Product Image 2</label>
            <input type="file" name="productIMG_2" class="w-full p-2 border rounded">
        </div>

        <!-- Product Image 3 -->
        <div class="w-1/2">
            <label class="block text-sm font-medium text-gray-700">Product Image 3</label>
            <input type="file" name="productIMG_3" class="w-full p-2 border rounded">
        </div>
    </div>

    <!-- Category -->
    <label class="block mt-4 text-sm font-medium text-gray-700">Category</label>
    <input type="text" name="category" required class="w-full p-2 border rounded">

    <!-- Popular & Latest -->
    <div class="flex gap-4 mt-4">
        <label><input type="checkbox" name="popular"> Popular</label>
        <label><input type="checkbox" name="latest"> Latest</label>
    </div>

    <!-- Submit -->
    <button type="submit" class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
        Create Product
    </button>
</form>

    </div>
</div>

<!-- JavaScript -->
<script>
    function openModal() {
        document.getElementById("modalOverlay").classList.remove("hidden");
    }
    function closeModal() {
        document.getElementById("modalOverlay").classList.add("hidden");
    }
</script>


     
</div>

<!-- Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-2xl relative">
        <!-- Close Button -->
        <button onclick="closeModal2()" class="absolute top-3 right-3 text-gray-600 hover:text-red-600 text-xl">&times;</button>

           <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Edit Product</h2>
<form method="POST" enctype="multipart/form-data" action="update_product.php">
    <input type="hidden" name="productID" id="productID">

    <!-- Title & Subtitle -->
    <div class="flex gap-4 mt-4">
        <div class="w-1/2">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" required class="w-full p-2 border rounded">
        </div>
        <div class="w-1/2">
            <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
            <input type="text" name="subtitle" id="subtitle" required class="w-full p-2 border rounded">
        </div>
    </div>

    <!-- Description -->
    <label for="description" class="block mt-4 text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" class="w-full p-2 border rounded" rows="3" required></textarea>

    <!-- Price & Discount -->
    <div class="flex gap-4 mt-4">
        <div class="w-1/2">
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" name="price" id="price" step="0.01" required class="w-full p-2 border rounded">
        </div>
        <div class="w-1/2">
            <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
            <input type="number" name="discount" id="discount" required class="w-full p-2 border rounded">
        </div>
    </div>

    <!-- Quantity & Product Images -->
    <div class="flex gap-4 mt-4">
        <div class="w-1/2">
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" id="quantity" required class="w-full p-2 border rounded">
        </div>

        <div class="w-1/2">
            <label for="productIMG" class="block text-sm font-medium text-gray-700">Product Image 1</label>
            <input type="file" name="productIMG" id="productIMG" class="w-full p-2 border rounded">
            <?php if (!empty($product['productIMG_name'])): ?>
                <p class="mt-2 text-sm text-gray-600">Current file: <?= htmlspecialchars($product['productIMG_name']) ?></p>
            <?php endif; ?>
        </div>
    </div>

   <div class="flex gap-4 mt-4">
    <div class="w-1/2">
        <label for="productIMG_2" class="block text-sm font-medium text-gray-700">Product Image 2</label>
        <input type="file" name="productIMG_2" id="productIMG_2" class="w-full p-2 border rounded">
        <?php if (!empty($product['productIMG_2_name'])): ?>
            <p class="mt-2 text-sm text-gray-600">Current file: <?= htmlspecialchars($product['productIMG_2_name']) ?></p>
        <?php endif; ?>
    </div>

    <div class="w-1/2">
        <label for="productIMG_3" class="block text-sm font-medium text-gray-700">Product Image 3</label>
        <input type="file" name="productIMG_3" id="productIMG_3" class="w-full p-2 border rounded">
        <?php if (!empty($product['productIMG_3_name'])): ?>
            <p class="mt-2 text-sm text-gray-600">Current file: <?= htmlspecialchars($product['productIMG_3_name']) ?></p>
        <?php endif; ?>
    </div>
</div>

    <!-- Category -->
    <label for="category" class="block mt-4 text-sm font-medium text-gray-700">Category</label>
    <input type="text" name="category" id="category" required class="w-full p-2 border rounded">

    <!-- Checkboxes -->
    <div class="flex gap-4 mt-4">
        <label class="text-sm"><input type="checkbox" name="popular" id="popular"> Popular</label>
        <label class="text-sm"><input type="checkbox" name="latest" id="latest"> Latest</label>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
        Update Product
    </button>
</form>


    </div>
</div>


<script>
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        document.getElementById('productID').value = this.dataset.id;
        document.getElementById('title').value = this.dataset.title;
        document.getElementById('subtitle').value = this.dataset.subtitle;
        document.getElementById('price').value = this.dataset.price;
        document.getElementById('discount').value = this.dataset.discount;
        document.getElementById('quantity').value = this.dataset.quantity;
        document.getElementById('description').value = this.dataset.description;
        document.getElementById('category').value = this.dataset.category;
        document.getElementById('popular').checked = this.dataset.popular == 1;
        document.getElementById('latest').checked = this.dataset.latest == 1;

        document.getElementById('editModal').classList.remove('hidden');
    });
});

function closeModal2() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>


</body>
</html>

