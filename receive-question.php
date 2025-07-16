<?php
// Connect to the database
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "petstore"; // Replace with your database name

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
<body class="bg-gray-50 font-sans antialiased">

    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-xl">

        <h2 class="text-3xl font-semibold text-gray-900 text-center mb-8">Admin Panel - View and Answer Questions</h2>

        <?php if (isset($message)) { ?>
            <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6 shadow-md text-center"><?php echo $message; ?></div>
        <?php } ?>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="bg-blue-600 text-white">
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
                                    <form method="POST" action="receive-question.php" class="space-y-4">
                                        <input type="hidden" name="ques_no" value="<?php echo $row['ques_no']; ?>">
                                        <textarea name="answer" rows="3" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your answer here..." required></textarea>
                                        <input type="hidden" name="action" value="submit_answer">
                                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Submit Answer</button>
                                    </form>
                                <?php } else { ?>
                                    <!-- If there is an existing answer, show the edit form -->
                                    <form method="POST" action="receive-question.php" class="space-y-4">
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
