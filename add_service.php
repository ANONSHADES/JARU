<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
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
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #218838;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <a href="services.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Services</a>
    <div class="form-container">
        <h1>Add Service</h1>
        <form method="post" action="save_service.php">
            <input type="text" name="name" placeholder="Service Name" required>
            <textarea name="description" rows="5" placeholder="Service Description" required></textarea>
            <input type="text" name="price_range" placeholder="Price Range" required>
            <button type="submit">Add Service</button>
        </form>
    </div>
</body>
</html>
