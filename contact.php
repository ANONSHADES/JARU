<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$isAdmin = $_SESSION['role'] == 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
            max-width: 800px;
        }
        .contact-info { 
            margin-top: 20px; 
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white to blend with background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contact-info p { 
            margin-bottom: 10px; 
            font-size: 18px;
        }
        .contact-info a { 
            display: block; 
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .contact-info a:hover {
            color: #555;
        }
        .contact-info i {
            margin-right: 10px;
        }
        .form-group {
            margin-top: 20px;
        }
        .form-group label {
            font-weight: bold;
            font-size: 18px;
            color: #fff; /* Adjust label color for contrast */
        }
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ddd;
            resize: vertical;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
        }
        .form-group button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group button:hover {
            background-color: #555;
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
        <h1>Contact Us</h1>
        <div class="contact-info">
            <p><i class="fas fa-envelope"></i> <a href="mailto:ianmwas896@gmail.com">ianmwas896@gmail.com</a></p>
            <p><i class="fab fa-whatsapp"></i> <a href="https://wa.me/254797074659">+254797074659</a></p>
            <p><i class="fas fa-map-marker-alt"></i> <a href="https://maps.google.com/?q=Juja%20Town">Juja Town</a></p>
        </div>
        <?php if ($isAdmin): ?>
            <form method="post" action="contact_update.php" class="form-group">
                <label for="contact_text">Update Contact Information:</label>
                <textarea id="contact_text" name="contact_text" rows="5" placeholder="You can contact us at: info@shoemending.com"></textarea>
                <button type="submit">Update</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- JavaScript to handle smooth scrolling for navbar links -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".navbar a").on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function(){
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>
</body>
</html>



