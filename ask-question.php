<?php
// Include database connection
$servername = "localhost";
$username = "root"; // Use your database username
$password = ""; // Use your database password
$dbname = "petstore"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert a new question into the database
function submitQuestion($email, $question, $conn) {
    $sql = "INSERT INTO comment_table (email, question, answer) VALUES (?, ?, '')"; // Assuming answer is empty initially
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $question);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : ''; // Get email from hidden input
    $question = isset($_POST['question']) ? $_POST['question'] : '';

    // Simple validation
    if (!empty($email) && !empty($question)) {
        // Sanitize inputs
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $question = htmlspecialchars($question);

        // Submit the question to the database
        submitQuestion($email, $question, $conn);

        // Redirect back to the same page (with the email in the URL)
        header("Location: ask-question.php?email=" . urlencode($email));
        exit; // Ensure no further code is executed after redirect
    } else {
        $error = "Both email and question are required.";
    }
}

// Get the email from query parameter (if available)
$email = isset($_GET['email']) ? $_GET['email'] : '';

// Query to fetch questions and answers for the given email
$sql = "SELECT question, answer FROM comment_table WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all the rows for display
$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions and Answers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-10 px-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">My Questions and Answers Panel</h1>

            <?php if (count($comments) > 0): ?>
                <div class="space-y-6">
                    <?php foreach ($comments as $comment): ?>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                            <p class="text-lg font-semibold text-gray-700">Question:</p>
                            <p class="text-gray-600"><?php echo htmlspecialchars($comment['question']); ?></p>
                            <p class="mt-4 text-lg font-semibold text-gray-700">Answer:</p>
                            <p class="text-gray-600"><?php echo htmlspecialchars($comment['answer']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-600">No questions found.</p>
            <?php endif; ?>

            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ask a New Question</h2>
                
                <?php if (isset($error)): ?>
                    <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Question Submission Form -->
                <form action="ask-question.php" method="POST" class="space-y-4">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <div>
                        <label for="question" class="block text-gray-700 font-semibold">Your Question</label>
                        <textarea name="question" id="question" rows="4" required
                                  class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit Question
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
