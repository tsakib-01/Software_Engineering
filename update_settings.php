<?php
session_start();
include('db_connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_settings'])) {
    $new_address = $_POST['address'] ?? '';
    $new_logo = null;
    $new_avatar = null;

    // Fetch current values in case no new file is uploaded
    $sql_fetch = "SELECT logo, avatar FROM settings_table LIMIT 1";
    $result = $conn->query($sql_fetch);
    $current_logo = '';
    $current_avatar = '';
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_logo = $row['logo'];
        $current_avatar = $row['avatar'];
    }

    // Handle logo upload
    if (!empty($_FILES['logo']['tmp_name'])) {
        $logo_tmp = $_FILES['logo']['tmp_name'];
        $logo_data = file_get_contents($logo_tmp);
        $new_logo = base64_encode($logo_data);
    } else {
        $new_logo = $current_logo;
    }

    // Handle avatar upload
    if (!empty($_FILES['avatar']['tmp_name'])) {
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $avatar_data = file_get_contents($avatar_tmp);
        $new_avatar = base64_encode($avatar_data);
    } else {
        $new_avatar = $current_avatar;
    }

    // Update settings
    $sql_update = "UPDATE settings_table SET address = ?, logo = ?, avatar = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sss", $new_address, $new_logo, $new_avatar);

    if ($stmt->execute()) {
        $_SESSION['update_success'] = true;
    } else {
        $_SESSION['update_success'] = false;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_settings.php");
    exit;
} else {
    header("Location: admin_settings.php");
    exit;
}
?>
