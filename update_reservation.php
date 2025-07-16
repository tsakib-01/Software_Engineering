<?php
include 'db_connection.php';

$reservationID = $_GET['id'] ?? null;

if (!$reservationID) {
    die("Invalid reservation ID.");
}

// Fetch reservation data
$stmt = $conn->prepare("SELECT * FROM reservations WHERE reservationID = ?");
$stmt->bind_param("i", $reservationID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Reservation not found.");
}

$reservation = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $number_of_people = $_POST['number_of_people'];
    $message = $_POST['message'];

    $update = $conn->prepare("UPDATE reservations SET fullName=?, email=?, phone=?, reservation_date=?, reservation_time=?, number_of_people=?, message=? WHERE reservationID=?");
    $update->bind_param("sssssssi", $fullName, $email, $phone, $reservation_date, $reservation_time, $number_of_people, $message, $reservationID);

    if ($update->execute()) {
        header("Location: admin_booking.php");
        exit;
    } else {
        echo "Error updating reservation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Update Reservation</h1>

        <form method="POST" class="space-y-4">
            <input type="text" name="fullName" value="<?= htmlspecialchars($reservation['fullName']) ?>" class="w-full p-2 border rounded" placeholder="Full Name" required>

            <input type="email" name="email" value="<?= htmlspecialchars($reservation['email']) ?>" class="w-full p-2 border rounded" placeholder="Email" required>

            <input type="text" name="phone" value="<?= htmlspecialchars($reservation['phone']) ?>" class="w-full p-2 border rounded" placeholder="Phone" required>

            <input type="date" name="reservation_date" value="<?= htmlspecialchars($reservation['reservation_date']) ?>" class="w-full p-2 border rounded" required>

            <input type="time" name="reservation_time" value="<?= htmlspecialchars($reservation['reservation_time']) ?>" class="w-full p-2 border rounded" required>

            <input type="number" name="number_of_people" value="<?= htmlspecialchars($reservation['number_of_people']) ?>" class="w-full p-2 border rounded" placeholder="# of People" required>

            <textarea name="message" class="w-full p-2 border rounded" placeholder="Message"><?= htmlspecialchars($reservation['message']) ?></textarea>

            <div class="flex justify-between">
                <a href="admin_booking.php" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Update Reservation</button>
            </div>
        </form>
    </div>

</body>
</html>
