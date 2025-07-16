<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $password = $_POST['password'];
    $email = $_POST['email'];

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $database = "rms_project";

    $conn = mysqli_connect($servername, $username, $db_password, $database);

    if (!$conn) {
        die("Connection was interrupted!: " . mysqli_connect_error());
    } else {
        // Check if the email and password match admin
        if ($email === 'admin@gmail.com' && $password === '777') {
            header("Location: admin.php");
            exit();
        }

        // Fetch user by email
        $check_query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Verify plain password
if ($password === $user['password']) {

                $first_name = $user['fname'];
                header("Location: welcome.php?first_name=$first_name&email=$email");
                exit();
            } else {
                $_SESSION['error_message'] = "Incorrect password.";
            }
        } else {
            $_SESSION['error_message'] = "Email not found.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  
  <title>Login</title>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

  <!-- Error Notification -->
  <?php if (isset($_SESSION['error_message'])) { ?>
    <div class="absolute top-4 bg-red-600 text-white text-center px-6 py-2 rounded shadow">
      <?php echo $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
  <?php } ?>

  <!-- Login Card -->
  <div class="bg-white shadow-md rounded-lg w-full max-w-md p-8">
  <?php
include('db_connection.php');

$sql_logo = "SELECT logo FROM settings_table LIMIT 1";
$result_logo = $conn->query($sql_logo);

$logo_img = '';

if ($result_logo && $result_logo->num_rows > 0) {
    $row = $result_logo->fetch_assoc();
    if (!empty($row['logo'])) {
        $logo_img = 'data:image/png;base64,' . $row['logo'];
    }
}
?>
<?php if (!empty($logo_img)): ?>
    <div class="flex justify-center mb-2">
        <img src="<?= $logo_img ?>" alt="Logo" class="h-16 object-contain">
    </div>
<?php else: ?>
    <h1 class="text-4xl font-bold text-center mb-2">Yummy<span class="text-red-600">.</span></h1>
<?php endif; ?>

  <h1 class="text-2xl font-bold text-center mb-2">Welcome back</h1>
      <p class="text-center text-gray-600 mb-6">Please enter your details</p>

      <form action="/rms_project/login.php" method="POST" class="space-y-4">
          <input class="w-full border border-gray-300 rounded px-3 py-2" type="email" name="email" placeholder="Email address" required>
          <input class="w-full border border-gray-300 rounded px-3 py-2" type="password" name="password" placeholder="Password" required>

          <input class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded" type="submit" value="Sign in">
      </form>

      <p class="text-center text-sm text-gray-600 mt-4">
          Don’t have an account?
          <a href="register.php" class="text-red-600 hover:underline">Create an account</a>
      </p>
  </div>

</body>
</html>
