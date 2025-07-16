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
     <a href="admin_products.php" class="flex items-center px-2 py-1 text-gray-700 rounded-lg hover:bg-purple-100 transition">
  <i class="fas fa-box-open mr-2 text-purple-600 text-sm"></i> Inventory
</a>

<a href="admin_customers.php" class="flex items-center px-2 py-1 rounded-lg bg-purple-100 text-purple-700 font-semibold transition">

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




        <!-- Main content -->
        <main class="flex-1 bg-gray-100 overflow-auto p-4 ml-64">
      

            <?php
            $conn = new mysqli("localhost", "root", "", "rms_project");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $message = "";
            $message_type = "";

            if (isset($_GET['delete'])) {
                $id = $_GET['delete'];
                $sql = "DELETE FROM users WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    $message = "Record deleted successfully!";
                    $message_type = "delete";
                } else {
                    $message = "Error: " . $conn->error;
                    $message_type = "error";
                }
            }

            if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $wishlist = $_POST['wishlist'];
                $password = $_POST['password'];

                $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email', address='$address', wishlist='$wishlist', password='$password' WHERE id=$id";

                if ($conn->query($sql) === TRUE) {
                    $message = "Record updated successfully!";
                    $message_type = "success";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    $message = "Error: " . $conn->error;
                    $message_type = "error";
                }
            }

            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            ?>

            <?php if ($message != "") { ?>
                <div class="mb-4 p-4 rounded shadow <?php echo $message_type == 'delete' ? 'bg-red-500' : ($message_type == 'success' ? 'bg-green-500' : 'bg-gray-500'); ?> text-white flex justify-between items-center">
                    <span><?php echo $message; ?></span>
                    <button onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            <?php } ?>

            <h3 class="text-xl font-semibold mb-4">All Records</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                        <tr class="bg-purple-600 text-white">
                            <th class="p-2 text-left">ID</th>
                            <th class="p-2 text-left">First Name</th>
                            <th class="p-2 text-left">Last Name</th>
                            <th class="p-2 text-left">Email</th>
                            <th class="p-2 text-left">Password</th>
                            <th class="p-2 text-left">Date</th>
                            <th class="p-2 text-left">Wishlist</th>
                            <th class="p-2 text-left">Address</th>
                            <th class="p-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='border-b'>
                                    <td class='p-2'>" . $row['id'] . "</td>
                                    <td class='p-2'>" . $row['fname'] . "</td>
                                    <td class='p-2'>" . $row['lname'] . "</td>
                                    <td class='p-2'>" . $row['email'] . "</td>
                                    <td class='p-2'>" . $row['password'] . "</td>
                                    <td class='p-2'>" . $row['created_at'] . "</td>
                                    <td class='p-2'>" . $row['wishlist'] . "</td>
                                    <td class='p-2'>" . $row['address'] . "</td>
                                    <td class='p-2'>
                                        <a href='?edit=" . $row['id'] . "' class='text-blue-600 hover:underline mr-2'>Edit</a>
                                        <a href='?delete=" . $row['id'] . "' class='text-red-600 hover:underline'>Delete</a>
                                    </td>
                                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center p-4'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM users WHERE id=$id";
                $editResult = $conn->query($sql);
                $editRow = $editResult->fetch_assoc();
            ?>
                <form method="POST" class="bg-white p-6 mt-6 rounded shadow-md">
                    <input type="hidden" name="id" value="<?php echo $editRow['id']; ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="fname" value="<?php echo $editRow['fname']; ?>" required class="p-2 border rounded">
                        <input type="text" name="lname" value="<?php echo $editRow['lname']; ?>" required class="p-2 border rounded">
                        <input type="email" name="email" value="<?php echo $editRow['email']; ?>" required class="p-2 border rounded">
                        <input type="text" name="wishlist" value="<?php echo $editRow['wishlist']; ?>" required class="p-2 border rounded">
                        <textarea name="address" required class="p-2 border rounded md:col-span-2"><?php echo $editRow['address']; ?></textarea>
                        <input type="password" name="password" value="<?php echo $editRow['password']; ?>" required class="p-2 border rounded">
                    </div>
                    <button type="submit" name="update" class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Update</button>
                </form>
            <?php } ?>

        </main>
    </div>
</body>

</html>