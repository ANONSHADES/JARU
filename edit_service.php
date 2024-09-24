<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];

    // Fetch service details from database
    $sql = "SELECT * FROM services WHERE id='$service_id'";
    $result = $conn->query($sql);
    $service = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            background-image: url('background.png'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
        }
        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff; /* Blue color for button */
            color: white;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Service</h1>
        <form method="post" action="update_service.php">
            <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
            <input type="text" name="name" value="<?php echo $service['name']; ?>" required>
            <textarea name="description" rows="10" required><?php echo $service['description']; ?></textarea>
            <input type="text" name="price_range" value="<?php echo $service['price_range']; ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

