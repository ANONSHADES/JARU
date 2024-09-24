<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.png'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh; /* Ensure full viewport height */
            overflow: hidden; /* Prevent scrolling */
        }
        .overlay {
            background-color: rgba(0, 0, 0, 0.6); /* Overlay to improve readability of content */
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            background-color: rgba(51, 51, 51, 0.7); /* Semi-transparent navbar background */
            padding: 1rem;
            width: 100%;
            box-sizing: border-box;
            position: fixed;
            top: 0;
            z-index: 1000;
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
        .welcome {
            text-align: center;
            margin-top: 20vh; /* Adjusted margin to center the content */
            color: white;
            font-size: 1.5rem;
            max-width: 600px;
            padding: 0 20px;
        }
        .username {
            font-weight: bold;
            font-size: 1.8rem;
            color: #ffc107; /* Yellow color for username */
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="about.php"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="services.php"><i class="fas fa-concierge-bell"></i> Our Services</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="testimonials.php"><i class="fas fa-comment-dots"></i> Testimonials</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="booked_services.php"><i class="fas fa-calendar-check"></i> Booked Services</a>
        <?php else: ?>
            <a href="booked_services.php"><i class="fas fa-calendar-check"></i> My Booked Services</a>
        <?php endif; ?>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <div class="username"><?php echo $_SESSION['username']; ?></div>
    </div>
    <div class="overlay">
        <div class="welcome">
            <h1>Welcome to Jaru Shoe Repair, your one-stop shop for shoe revival!</h1>
            <p>We breathe new life into your favorite footwear, so you can keep them looking and feeling their best.</p>
            <p><span class="username"><?php echo $_SESSION['username']; ?></span>, this is your personalized dashboard. Explore the options above to manage your account and services.</p>
        </div>
    </div>
</body>
</html>

