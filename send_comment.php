<?php
session_start();

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'petstore';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in by checking session
if (!isset($_SESSION['id'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id']; // User ID stored in session

// Fetch user information from the personalinfo table based on the logged-in user ID
$sql = "SELECT fname, lname, email FROM personalinfo WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user exists in the personalinfo table
if (!$user) {
    echo "User not found.";
    exit();
}

// Check if the email is already saved in session
if (!isset($_SESSION['email'])) {
    // If it's the first time submitting a comment, save the user's email in the session
    $_SESSION['email'] = $user['email'];
}

// Handle the form submission (if the comment is posted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = htmlspecialchars($_POST['comment']); // Get the comment from the form
    $email = $_SESSION['email']; // Get email from session

    // Prepare SQL query to insert the comment into the comment_table
    $sql_insert = "INSERT INTO comment_table (id, first_name, last_name, email, comment, date) 
                   VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("issss", $user_id, $user['fname'], $user['lname'], $email, $comment);
    if ($stmt_insert->execute()) {
        echo "Your comment has been posted successfully!";
    } else {
        echo "Error posting comment. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Comment</title>
</head>
<body>
    <!-- Display the notification message if first name is set -->
    <?php if (isset($user['fname'])): ?>
        <div id="notification" class="notification">
            <i class="bi bi-check-circle"></i>
            <strong>Welcome Back, <?= htmlspecialchars($user['fname']); ?>!</strong>
            You have successfully logged in. We are glad to have you back!
            <button onclick="closeNotification()">&times;</button>
        </div>
    <?php endif; ?>

    <h2>Post Your Comment</h2>
    <form action="post_comment.php" method="POST">
        <label for="email">Your Email:</label><br>
        <input type="email" id="email" name="email" value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" readonly><br><br>

        <label for="comment">Your Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Submit Comment</button>
    </form>

    <script>
        function closeNotification() {
            document.getElementById("notification").style.display = "none";
        }
    </script>
</body>
</html>
