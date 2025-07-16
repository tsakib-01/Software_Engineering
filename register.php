<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

// DB config
$conn = new mysqli("localhost", "root", "", "rms_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d).{8,}$/", $password)) {
        $_SESSION['error_message'] = "Password must be at least 8 characters with one uppercase letter and one number.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['error_message'] = "Email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $token = bin2hex(random_bytes(32));
            $expires = date("Y-m-d H:i:s", strtotime("+1 day"));

            $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, address, password, verification_token, token_expires) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $fname, $lname, $email, $address, $hashedPassword, $token, $expires);
            if ($stmt->execute()) {
                // Send verification email
              $verifyLink = "http://localhost/rms_project/verify.php?email=" . urlencode($email) . "&token=" . $token;
 $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sujoyarnab972@gmail.com';  // Use your Gmail
                    $mail->Password = 'jdya lbnk ndfy fkqp';     // Use app password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('sujoyarnab972@gmail.com', 'Yummy Restaurant');
                    $mail->addAddress($email, "$fname $lname");

                    $mail->isHTML(true);
                    $mail->Subject = 'Verify your email address';
                    $mail->Body = "<p>Hello <strong>$fname</strong>,</p>
                                   <p>Thanks for registering at Yummy Restaurant. Please click the link below to verify your email:</p>
                                   <a href='$verifyLink'>Verify Email</a>";

               $mail->send();
$_SESSION['email'] = $email;
$_SESSION['success_message'] = "Registration successful! Please check your email to verify your account.";
header("Location: /rms_project/email_verificarion.php");
exit;

                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Mailer Error: " . $mail->ErrorInfo;
                }
            } else {
                $_SESSION['error_message'] = "Error saving user. Try again.";
            }
        }
    }
    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}

}
$conn->close();
?>

<!-- Frontend -->
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
<?php if (isset($_SESSION['error_message'])): ?>
<div class="absolute top-4 bg-red-600 text-white text-center px-6 py-2 rounded shadow">
    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
</div>
<?php endif; ?>

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
    <h1 class="text-center text-xl mb-2 font-bold">Create a new account</h1>
    <p class="text-sm text-center mb-6">Join us, it's quick and easy!</p>

    <form action="" method="POST" class="space-y-4">
        <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" name="first_name" placeholder="First Name" required>
        <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" name="last_name" placeholder="Last Name" required>
        <input class="w-full border border-gray-300 rounded px-3 py-2" type="email" name="email" placeholder="Email address" required>
        <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" name="address" placeholder="Home Address" required>
        <input class="w-full border border-gray-300 rounded px-3 py-2" type="password" name="password" placeholder="Password" required>
        <input class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded" type="submit" value="Register">
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
        Already have an account? <a href="login.php" class="text-red-600 hover:underline">Login here</a>
    </p>
</div>
</body>
</html>
