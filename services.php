<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$isAdmin = $_SESSION['role'] == 'admin';

include 'db.php';

// Fetch services from the database
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            background-image: url('background.png'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 1rem;
            position: sticky; /* Sticky navbar */
            top: 0;
            z-index: 1000; /* Ensure navbar stays on top */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            transition: all 0.3s ease;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .content {
            padding: 20px;
            margin: auto;
            max-width: 1000px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th,
        table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .buttons form {
            display: inline;
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .book-btn {
            background-color: #007BFF;
            color: white;
        }
        .add-btn,
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin: 10px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }
        .add-btn {
            background-color: #28a745;
            color: white;
        }
        .back-btn {
            background-color: #6c757d;
            color: white;
        }
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input,
        .form-container textarea {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-container button {
            width: 100%;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #28a745;
            color: white;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover,
        .buttons button:hover,
        .add-btn:hover,
        .back-btn:hover {
            background-color: #555;
        }

        /* Style for the title */
        h1 {
            color: #fff; /* White color for contrast */
            text-align: center;
            margin-top: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Optional: text shadow for better visibility */
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="services.php"><i class="fas fa-concierge-bell"></i> Our Services</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="testimonials.php"><i class="fas fa-comment-dots"></i> Testimonials</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="content">
        <h1>Our Services</h1>
        <?php if ($isAdmin): ?>
            <a href="add_service.php" class="add-btn"><i class="fas fa-plus"></i> Add Service</a>
        <?php endif; ?>
        <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price Range</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['name']); ?></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td><?php echo htmlspecialchars($service['price_range']); ?></td>
                        <td>
                            <div class="buttons">
                                <?php if ($isAdmin): ?>
                                    <form method="post" action="edit_service.php">
                                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                        <button class="edit-btn" type="submit">Edit</button>
                                    </form>
                                    <form method="post" action="delete_service.php">
                                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                        <button class="delete-btn" type="submit">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <form method="post" action="book_service.php">
                                        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                        <button class="book-btn" type="submit">Book Service</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>




