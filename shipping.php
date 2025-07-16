<?php
// Get email from query string
$email = isset($_GET['email']) ? $_GET['email'] : '';

// Fetch user's name and address (this can be extended to include more fields if necessary)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petstore";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user's information
$query = "SELECT fname, lname, address FROM personalinfo WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Information</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Shipping Information</h2>

        <form action="confirmation.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

            <div class="space-y-4">
                <div>
                    <label for="fname" class="block text-gray-700 font-semibold">First Name</label>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="lname" class="block text-gray-700 font-semibold">Last Name</label>
                    <input type="text" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="address" class="block text-gray-700 font-semibold">Shipping Address</label>
                    <textarea name="address" rows="4" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg text-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Proceed to Confirmation
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
