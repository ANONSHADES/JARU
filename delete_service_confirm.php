<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    $sql = "DELETE FROM services WHERE id='$service_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Service successfully deleted.');
        window.location.href = 'services.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: services.php");
}
?>
