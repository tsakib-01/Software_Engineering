<?php
// Database connection
$servername = "localhost";  // replace with your database server
$username = "root";         // replace with your database username
$password = "";             // replace with your database password
$dbname = "petstore";       // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user_id = 1;  // You can change this based on the logged-in user
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Insert the data into the comment_table
    $sql = "INSERT INTO comment_table (user_id, first_name, last_name, email, comment)
            VALUES ('$user_id', '$first_name', '$last_name', '$email', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "New comment added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
