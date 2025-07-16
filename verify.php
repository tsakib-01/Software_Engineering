<?php
$conn = new mysqli("localhost", "root", "", "rms_project");

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

$status = '';
$success = false;

if ($email && $token) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND verification_token=? AND token_expires >= NOW()");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE email=?");
        $update->bind_param("s", $email);
        $update->execute();
        $status = "✅ Your email has been verified successfully. You can now login to your account.";
        $success = true;
    } else {
        $status = "❌ This verification link is invalid or has expired.";
    }
} else {
    $status = "❌ Missing or incorrect verification parameters.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/x-icon" href="LOGO.png">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

  <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
    <h1 class="text-3xl font-bold mb-4 text-red-600">Yummy<span class="text-black">.</span></h1>
    
    <div class="mb-4">
      <?php if ($success): ?>
        <p class="text-green-600 font-medium text-lg"><?php echo $status; ?></p>
        <a href="login.php" class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-medium">Login Now</a>
      <?php else: ?>
        <p class="text-red-600 font-medium text-lg"><?php echo $status; ?></p>
      <?php endif; ?>
    </div>

    <div class="mt-6">
      <a href="index.php" class="text-sm text-gray-600 hover:text-black underline">Go to Homepage</a>
    </div>
  </div>

</body>
</html>
