<?php
include 'db_connection.php';

$reservationID = $_GET['id'] ?? null;

if (!$reservationID) {
    die("Invalid reservation ID.");
}

// Check if reservation exists
$stmt = $conn->prepare("SELECT * FROM reservations WHERE reservationID = ?");
$stmt->bind_param("i", $reservationID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Reservation not found.");
}
$stmt->close();

// Delete reservation
$delete = $conn->prepare("DELETE FROM reservations WHERE reservationID = ?");
$delete->bind_param("i", $reservationID);

if ($delete->execute()) {
    header("Location: admin_booking.php");
    exit;
} else {
    echo "Error deleting reservation.";
}
?>
