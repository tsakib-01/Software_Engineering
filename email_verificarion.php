<?php
session_start();
$conn = new mysqli("localhost", "root", "", "rms_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If user is already verified, redirect to login
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT is_verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($is_verified);
    $stmt->fetch();
    $stmt->close();

    if ($is_verified) {
        header("Location: login.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="10"> <!-- Refresh every 10 seconds to check verification -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
    <h2 class="text-3xl font-bold mb-4 text-red-600">Almost there!</h2>
    <p class="text-gray-700 mb-6">We’ve sent a verification link to your email. Please check your inbox and click the link to verify your account.</p>

    <a href="https://mail.google.com" target="_blank" class="inline-block w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded mb-4">
        Verify Email
    </a>

    <p class="text-sm text-gray-500">After verifying, you will be redirected to the login page.</p>
</div>

</body>
</html>
