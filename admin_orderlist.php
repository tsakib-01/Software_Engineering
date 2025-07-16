<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order List</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="flex bg-gray-100 min-h-screen">

  <!-- Sidebar -->
 <aside class="w-64 bg-white border-r min-h-screen p-4 shadow-md">
  <h1 class="text-xl font-extrabold text-purple-700 mb-6 tracking-wide">DEMO</h1>

  <nav class="space-y-4 text-sm">
    <!-- Dashboard -->
    <a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
      <i class="fas fa-home mr-2 text-purple-600 text-base"></i>
      <span>Dashboard</span>
    </a>

    <!-- Products Section -->
   <!-- Products Section -->
   
   <a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
       <i class="fas fa-box-open mr-2 text-purple-600 text-sm"></i> Inventory
     </a>
    
    
    
    <!-- Other Menu Items -->
    <a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
        <i class="fas fa-tags mr-2 text-purple-600 text-sm"></i> Flash Sales
    </a>
    <a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
        <i class="fas fa-users mr-2 text-purple-600 text-sm"></i> Customers
    </a>
    <!-- Orders Section -->
    <div class="mt-4">
        <p class="flex items-center px-2 py-1 text-gray-800 font-semibold uppercase tracking-wide text-xs">
            <i class="fas fa-shopping-cart mr-2 text-purple-600 text-sm"></i> Orders
  </p>
  <ul class="ml-5 mt-1 space-y-1 text-xs">
      <a href="order-list.html"><li class="px-2 py-1 rounded-md bg-purple-100 text-purple-700 font-semibold">Order List</li></a>
    <a href="pending-orders.html"><li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Pending Orders</li></a>
   <a href="completed-orders.html"> <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Completed Orders</li></a>
    <a href="cancelled-orders.html"><li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Cancelled Orders</li></a>
    <!-- <li class="px-2 py-1 rounded-md hover:bg-gray-100 text-gray-700">Add New Order</li> -->
  </ul>
</div>
<div class="space-y-2 border-t pt-3 mt-3">

<a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
    <i class="fas fa-chart-line mr-2 text-purple-600 text-sm"></i> Analytics
</a>
<a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
    <i class="fas fa-bell mr-2 text-purple-600 text-sm"></i> Notifications
      </a>
      <a href="#" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
        <i class="fas fa-cog mr-2 text-purple-600 text-sm"></i> Settings
      </a>
    </div>
  </nav>

  <!-- Logout -->
  <button class="mt-6 flex items-center text-red-500 hover:text-red-600 text-xs px-2 py-1 transition">
    <i class="fas fa-sign-out-alt mr-2 text-sm"></i> Log out
  </button>
</aside>

 <?php
include('db_connection.php');

// Fetch all orders
$sql = "SELECT order_id, order_userfname, order_useremail, order_total_cost, order_date, order_quantity, payment 
        FROM order_table 
        ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!-- Admin Order Dashboard -->
<main class="flex-1 p-8">
    <h2 class="text-2xl font-bold mb-6">Order List</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm bg-white rounded shadow">
            <thead class="bg-gray-100">
                <tr class="text-left">
                    <th class="p-4">Order ID</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Items</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Payment</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="p-4">#<?= $row['order_id'] ?></td>
                            <td class="p-4"><?= htmlspecialchars($row['order_userfname']) ?> (<?= htmlspecialchars($row['order_useremail']) ?>)</td>
                            <td class="p-4"><?= $row['order_quantity'] ?></td>
                            <td class="p-4">Tk.<?= number_format($row['order_total_cost'], 2) ?></td>
                            <td class="p-4"><?= date('Y-m-d', strtotime($row['order_date'])) ?></td>
                            <td class="p-4">
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs"><?= htmlspecialchars($row['payment']) ?></span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php $conn->close(); ?>

</body>
</html>
