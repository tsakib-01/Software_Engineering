<?php
include('db_connection.php');

// Fetch the settings from the database
$sql = "SELECT address, logo, avatar FROM settings_table LIMIT 1";
$result = $conn->query($sql);

// Initialize variables
$address = '';
$logo = '';
$avatar = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $address = $row['address'];
    $logo = $row['logo'];
    $avatar = $row['avatar'];
} else {
    echo "No settings found.";
}

// Count completed orders
$sql_total_orders = "SELECT COUNT(*) AS total_orders FROM order_table";

$result_total_orders = $conn->query($sql_total_orders);
$total_orders = 0;

if ($result_total_orders->num_rows > 0) {
    $row = $result_total_orders->fetch_assoc();
    $total_orders = $row['total_orders'];
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
      
  <a href="admin.php" class="flex items-center px-2 py-1 rounded-lg bg-purple-100 text-purple-700 font-semibold transition">

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




    <!-- Main Panel -->
    <div class="w-full md:w-10/12 p-4 md:p-8">
      

        <?php
        $conn = new mysqli("localhost", "root", "", "rms_project");
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        $sql = "SELECT COUNT(*) AS total_users FROM users";
        $sql2 = "SELECT COUNT(*) AS total_products FROM `product_table`";
        $sql3 = "SELECT COUNT(*) AS total_comments FROM `comment_table`";
        $sql4 = "SELECT COUNT(*) AS total_pending FROM `cart_table`";
       $sql5 = "SELECT SUM(order_total_cost) AS total_sales FROM `order_table`";


        $result = $conn->query($sql);
        $totalUsers = $result->num_rows > 0 ? $result->fetch_assoc()['total_users'] : 0;

        $result2 = $conn->query($sql2);
        $totalProducts = $result2->num_rows > 0 ? $result2->fetch_assoc()['total_products'] : 0;

        $result3 = $conn->query($sql3);
        $totalComments = $result3->num_rows > 0 ? $result3->fetch_assoc()['total_comments'] : 0;

        $result4 = $conn->query($sql4);
        $totalPending = $result4->num_rows > 0 ? $result4->fetch_assoc()['total_pending'] : 0;

        $result5 = $conn->query($sql5);
        $totalSales = $result5->num_rows > 0 ? $result5->fetch_assoc()['total_sales'] : 0;

        $conn->close();
        ?>
<!-- 
<style>
    *{
        outline: 2px solid red;
    }
</style> -->

        <div class="flex flex-wrap gap-4 lg:gap-8 mt-4 ml-80">
            <!-- Dashboard Cards -->
            <?php
            $cards = [
                ["Users", "users", $totalUsers, "admin_customers.php", "blue-600", "users"],
                ["Orders", "shopping-cart", $total_orders, "admin_orders.php", "orange-500", "orders"],
                ["Sales", "money", $totalSales, null, "green-600", "sales"],
                ["Comments", "comments", $totalComments, "admin_comments.php", "yellow-400", "comments"],
                ["Products", "cubes", $totalProducts, "admin_products.php", "purple-600", "products"],
                ["Pending", "exclamation-triangle", $totalPending, "admin_orders.php", "red-600", "pending"]
            ];

            foreach ($cards as [$title, $icon, $value, $link, $color, $id]) {
                echo '<div class="flex-1 min-w-[280px] bg-white text-gray-900 rounded-lg shadow-xl border-l-4 border-' . $color . ' p-6 transform hover:scale-105 transition duration-300">';
                if ($link) echo '<a href="' . $link . '">';
                echo '<div class="flex items-center mb-4">
                        <i class="fa fa-' . $icon . ' text-' . $color . ' text-3xl mr-3"></i>
                        <div class="text-lg font-semibold">Total ' . $title . '</div>
                      </div>
                      <div class="text-4xl font-bold tracking-tight" id="total-' . $id . '">' . $value . '</div>
                      <div class="border-t-2 border-gray-200 mt-4 pt-2 text-sm text-gray-500">';
                echo $title === "Sales" ? "Amount Earned" : ($title === "Pending" ? "Customers in Cart" : "Total " . $title);
                echo '</div>';
                if ($link) echo '</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
function countdown(elementId, startValue, endValue) {
    let currentValue = startValue;
    const element = document.getElementById(elementId);

    const totalSteps = 500;
    const intervalTime = 1000 / totalSteps;

    const interval = setInterval(() => {
        element.textContent = currentValue;
        currentValue += (startValue > endValue) ? -1 : 1;
        if (currentValue === endValue) {
            clearInterval(interval);
            element.textContent = endValue;
        }
    }, intervalTime);
}

countdown("total-users", 999, <?php echo $totalUsers; ?>);
countdown("total-orders", 999, <?php echo $total_orders; ?>);
countdown("total-sales", 0, Math.min(<?php echo $totalSales; ?>));

countdown("total-comments", 999, <?php echo $totalComments; ?>);
countdown("total-products", 999, <?php echo $totalProducts; ?>);
countdown("total-pending", 999, <?php echo $totalPending; ?>);
</script>
</body>
</html>
