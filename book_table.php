<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $people = $_POST['people'] ?? 1;
    $message = $_POST['message'] ?? '';

    $stmt = $conn->prepare("INSERT INTO reservations (fullName, email, phone, reservation_date, reservation_time, number_of_people, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $name, $email, $phone, $date, $time, $people, $message);

    if ($stmt->execute()) {
  echo "<script>
    alert('Reservation successful!');
    window.location.href='welcome.php?first_name=" . urlencode($name) . "&email=" . urlencode($email) . "';
</script>";
 } else {
        echo "<script>alert('Failed to book table.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
