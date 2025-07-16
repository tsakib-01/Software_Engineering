<?php
include 'db_connection.php';
$reservations = [];

$sql = "SELECT * FROM reservations ORDER BY reservation_date DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}
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
     
<a href="admin_booking.php" class="flex items-center px-2 py-1 rounded-lg bg-purple-100 text-purple-700 font-semibold transition">

 <i class="fas fa-calendar-check mr-2 text-purple-600 text-sm"></i> Bookings

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
    <!-- Main Content -->
<div class="w-full md:w-10/12 p-4 ml-64 md:p-8">
    <div class="flex justify-end mb-6">
        <a href="http://localhost/rms_project/login.php" class="bg-blue-600 hover:bg-blue-700 text-white pt-1 pb-1 pl-2 pr-2 rounded-lg">Logout</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Booking Reservations</h2>

        <div class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center">
            Booking data loaded successfully.
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center">Name</th>
                        <th class="px-4 py-2 text-center">Email</th>
                        <th class="px-4 py-2 text-center">Phone Number</th>
                        <th class="px-4 py-2 text-center">Date</th>
                        <th class="px-4 py-2 text-center">Time</th>
                        <th class="px-4 py-2 text-center">No. of People</th>
                        <th class="px-4 py-2 text-center">Message</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
         <tbody class="bg-white divide-y divide-gray-200">
    <?php if (count($reservations) > 0): ?>
        <?php foreach ($reservations as $res): ?>
            <tr>
                <td class="px-4 py-3 text-center"><?= htmlspecialchars($res['fullName']) ?></td>
                <td class="px-4 py-3 text-center"><?= htmlspecialchars($res['email']) ?></td>
                <td class="px-4 py-3 text-center"><?= htmlspecialchars($res['phone']) ?></td>
                <td class="px-4 py-3 text-center"><?= date('F d, Y', strtotime($res['reservation_date'])) ?></td>
                <td class="px-4 py-3 text-center"><?= date('h:i A', strtotime($res['reservation_time'])) ?></td>
                <td class="px-4 py-3 text-center"><?= htmlspecialchars($res['number_of_people']) ?></td>
                <td class="px-4 py-3 text-center"><?= nl2br(htmlspecialchars($res['message'])) ?></td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="update_reservation.php?id=<?= $res['reservationID'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded">Update</a>
                        <a href="delete_reservation.php?id=<?= $res['reservationID'] ?>" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="8" class="text-center py-4 text-gray-500">No reservations found.</td></tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>
    </div>
</div>

</div>
</body>
</html>
