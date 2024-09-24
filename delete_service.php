<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];

    // Confirm before deletion
    echo "<script>
    if (confirm('Are you sure you want to delete this service?')) {
        window.location.href = 'delete_service_confirm.php?service_id=$service_id';
    } else {
        window.location.href = 'services.php';
    }
    </script>";
}
?>

