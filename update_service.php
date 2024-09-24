<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price_range = $_POST['price_range'];

    $sql = "UPDATE services SET name='$name', description='$description', price_range='$price_range' WHERE id='$service_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Service successfully updated.');
        window.location.href = 'services.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

