<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price_range = $_POST['price_range'];

    $sql = "INSERT INTO services (name, description, price_range) VALUES ('$name', '$description', '$price_range')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Service successfully added.');
        window.location.href = 'services.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

