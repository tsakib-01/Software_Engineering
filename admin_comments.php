<?php
include('db_connection.php');

// Fetch the settings from the database
$sql = "SELECT address, logo,  avatar FROM settings_table LIMIT 1";
$result = $conn->query($sql);

// Initialize variables
$address = '';
$logo = '';
$thank_you_img = '';

// Check if there's a row fetched
if ($result->num_rows > 0) {
    // Fetch the row
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
        <a href="admin_comments.php" class="flex items-center px-2 py-1 rounded-lg bg-purple-100 text-purple-700 font-semibold transition">


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



      <?php
// Connect to the database
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "rms_project"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all questions, regardless of whether they have been answered
$sql = "SELECT * FROM comment_table ORDER BY comment_date DESC";

$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle both answering and editing
    $answer = htmlspecialchars($_POST['answer']); // Sanitize the answer input
    $ques_no = $_POST['ques_no']; // The question number

    // Check if answer and ques_no are set before proceeding
    if (isset($answer) && isset($ques_no)) {
        if ($_POST['action'] == 'submit_answer') {
            // Update the answer when submitted
            $stmt = $conn->prepare("UPDATE comment_table SET answer=? WHERE ques_no=?");
            $stmt->bind_param("si", $answer, $ques_no);  // "si" means string and integer parameters

            if ($stmt->execute()) {
                $message = "Answer has been submitted successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } elseif ($_POST['action'] == 'edit_answer') {
            // Update the answer when editing
            $stmt = $conn->prepare("UPDATE comment_table SET answer=? WHERE ques_no=?");
            $stmt->bind_param("si", $answer, $ques_no);  // "si" means string and integer parameters

            if ($stmt->execute()) {
                $message = "Answer has been updated successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        $message = "Answer or Question number is missing!";
    }
}

// Fetch updated data after answer submission or edit
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View and Answer Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <div class="max-w-6xl mx-auto ml-72 mt-10 p-6 bg-white rounded-lg shadow-xl">

        <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Comments Information</h2>

        <?php if (isset($message)) { ?>
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 shadow-md text-center"><?php echo $message; ?></div>
        <?php } ?>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-center">Email</th>
                        <th class="px-6 py-3 text-center">Question</th>
                        <th class="px-6 py-3 text-center">Date</th>
                        <th class="px-6 py-3 text-center">Answer</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center"><?php echo $row['email']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $row['question']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo date("F j, Y, g:i a", strtotime($row['comment_date'])); ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php 
                                    if ($row['answer']) {
                                        echo $row['answer'];  // Show the answer if it exists
                                    } else {
                                        echo '<span class="text-yellow-500 font-semibold">No Answer Yet</span>'; // Show 'No Answer Yet' if the answer is empty
                                    }
                                ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if (!$row['answer']) { ?>
                                    <form method="POST" action="admin_comments.php" class="space-y-4">
                                        <input type="hidden" name="ques_no" value="<?php echo $row['ques_no']; ?>">
                                        <textarea name="answer" rows="3" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your answer here..." required></textarea>
                                        <input type="hidden" name="action" value="submit_answer">
                                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Submit Answer</button>
                                    </form>
                                <?php } else { ?>
                                    <!-- If there is an existing answer, show the edit form -->
                                    <form method="POST" action="admin_comments.php" class="space-y-4">
                                        <input type="hidden" name="ques_no" value="<?php echo $row['ques_no']; ?>">
                                        <textarea name="answer" rows="3" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $row['answer']; ?></textarea>
                                        <input type="hidden" name="action" value="edit_answer">
                                        <button type="submit" class="w-full bg-yellow-600 text-white py-2 rounded-md hover:bg-yellow-700 transition">Edit Answer</button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>


<!-- customers -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->


<!-- products -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->


<!-- comments -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->


<!-- settings -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->



</div>




<!-- 
<style>
  *{

    outline: 1px solid red;
  }
</style> -->


</body>
</html>