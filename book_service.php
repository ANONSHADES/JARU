<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];
    $username = $_SESSION['username'];

    // Fetch service details to autofill the form
    $sql = "SELECT * FROM services WHERE id = '$service_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
    } else {
        echo "Error: Service not found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service_id = $_POST['service_id'];
    $username = $_SESSION['username'];

    // Generate a booking number (you can modify this as needed)
    $booking_number = generateBookingNumber();

    // Save booking details to the database
    $sql = "INSERT INTO booked_services (booking_number, service_id, username, email, phone)
            VALUES ('$booking_number', '$service_id', '$username', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Booking successful. Your booking number is: $booking_number');
        window.location.href = 'services.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}

function generateBookingNumber() {
    // Generate a random booking number based on timestamp and random characters
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 8; // Length of the booking number
    $booking_number = '';

    // Add timestamp part (e.g., YYYYMMDDHHMMSS)
    $booking_number .= date('YmdHis');

    // Add random characters
    for ($i = 0; $i < $length - 14; $i++) {
        $booking_number .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $booking_number;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
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
        .form-container input {
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
            background-color: #007BFF;
            color: white;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #0056b3;
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
    <div class="form-container">
        <h1>Book Service</h1>
        <form method="post">
            <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
            <label for="service_name">Selected Service:</label>
            <input type="text" id="service_name" name="service_name" value="<?php echo $service['name']; ?>" readonly>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <button type="submit" name="submit">Submit</button>
        </form>
        <a href="services.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Services</a>
    </div>
</body>
</html>

