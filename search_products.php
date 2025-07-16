<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rms_project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the AJAX request
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$results = [];

if ($searchQuery !== '') {
    // Search query in the titles of the products
    $sql = "SELECT * FROM product_table WHERE titles LIKE ? LIMIT 5";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchQuery . "%"; // Prepare for SQL LIKE query
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'title' => $row['titles'],
            'id' => $row['productID'],
            'img' => $row['productIMG'],  // The base64 image from the database
            'price' => $row['price'],
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($results);

$conn->close();
?>
