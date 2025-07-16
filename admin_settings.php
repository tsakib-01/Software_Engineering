<?php
include('db_connection.php');

// Fetch the settings from the database
$sql = "SELECT address, logo, avatar FROM settings_table LIMIT 1";
$result = $conn->query($sql);

// Initialize variables
$address = '';
// $delivery_info = '';
$logo = '';
// $thank_you_img = '';

// Check if there's a row fetched
if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $address = $row['address'];
    // $delivery_info = $row['delivery_info'];
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
     <a href="admin_products.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
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
       <a href="admin_settings.php" class="flex items-center px-2 py-1 rounded-lg bg-purple-100 text-purple-700 font-semibold transition">

 <i class="fas fa-cog mr-2 text-purple-600 text-sm"></i> Settings
        </a>
      </div>
    </nav>
    <a href="login.php">
    <button class="mt-6 flex items-center text-red-500 hover:text-red-600 text-xs px-2 py-1 transition">
      <i class="fas fa-sign-out-alt mr-2 text-sm"></i> Log out
    </button></a>
  </aside>


<!-- dashboard -->
<div class="w-full md:w-10/12 p-4 md:p-8 ml-64">
    

    <!-- Settings Panel Form -->
    <div class="text-4xl flex justify-center mb-8">Settings Panel</div>

    <!-- Settings Form -->
    <form action="update_settings.php" method="POST" enctype="multipart/form-data" class="space-y-6">


    <!-- <div>
            <label for="avatar" class="block font-semibold">Profile Image (512 x 512 px) (PNG/JPG):</label>
            <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg" class="p-2">
            <?php if ($avatar): ?>
                <div class="mt-2">
                    <img src="data:image/png;base64,<?php echo $avatar; ?>" alt="Avatar Image" width="100">
                </div>
            <?php endif; ?>
        </div> -->


        <div>
            <label for="address" class="block font-semibold">Address:</label>
            <textarea id="address" name="address" rows="4" cols="50" class="p-2 border w-full"><?php echo htmlspecialchars($address); ?></textarea>
        </div>

        <!-- <div>
            <label for="delivery_info" class="block font-semibold">Delivery Information:</label>
            <textarea id="delivery_info" name="delivery_info" rows="4" cols="50" class="p-2 border w-full"><?php echo htmlspecialchars($delivery_info); ?></textarea>
        </div> -->



        <div>
            <label for="logo" class="block font-semibold">Logo Image (PNG/JPG):</label>
            <input type="file" id="logo" name="logo" accept="image/png, image/jpeg" class="p-2">
            <?php if ($logo): ?>
                <div class="mt-2">
                    <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Current Logo" width="100">
                </div>
            <?php endif; ?>
        </div>

   


    

        <div>
            <button type="submit" name="update_settings" class="pt-2 pb-2 pl-4 pr-4 mb-5 rounded-lg bg-purple-600 text-white">Update Settings</button>
        </div>
    </form>
</div>

</div>

</body>
</html>
