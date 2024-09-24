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
    <title>About Us - Jaru Shoe Repair</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            background-image: url('background.png'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh; /* Adjust as needed */
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .content {
            padding: 20px;
            color: #333; /* Text color for content */
        }
        .section {
            background-color: rgba(255, 255, 255, 0.9); /* Light background for sections */
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s ease, transform 1s ease;
        }
        .section.show {
            opacity: 1;
            transform: translateY(0);
        }
        .section h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333; /* Heading color */
        }
        .section p, .section ul {
            font-size: 16px;
            line-height: 1.6;
        }
        .update-form {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Form background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .update-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
        .update-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007BFF; /* Button background color */
            color: white;
        }
        .update-form button:hover {
            background-color: #0056b3; /* Button hover background color */
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
        <div id="about" class="section">
            <h2>Welcome to Jaru Shoe Repair</h2>
            <p>We are where craftsmanship meets care. With decades of experience in the art of shoe mending, we take pride in restoring your favorite footwear to its former glory. Located in the heart of Juja's, our shop is a haven for shoe enthusiasts who value both style and durability.</p>
        </div>
        <div id="mission" class="section">
            <h2>Our Mission</h2>
            <p>At Jaru Shoe Repair, our mission is simple yet profound: to breathe new life into every pair of shoes that comes through our door. Whether it's a beloved pair of heels, dress shoes, or casual sneakers, each shoe is treated with meticulous attention to detail and respect for its unique history.</p>
        </div>
        <div id="craftsmanship" class="section">
            <h2>Expert Craftsmanship</h2>
            <p>Our team of skilled cobblers brings a wealth of knowledge and expertise to every repair. From replacing worn-out soles and heels to intricate stitching and leather restoration, we use traditional techniques combined with modern tools to ensure the highest quality craftsmanship.</p>
        </div>
        <div id="services" class="section">
            <h2>Services We Offer</h2>
            <ul>
                <li>Sole Replacement: Extend the life of your shoes with our expert sole replacement service. Choose from a range of durable materials to suit your needs.</li>
                <li>Heel Repair: Restore stability and comfort with our professional heel repair services. We fix worn-down heels and ensure even wear for a smoother stride.</li>
                <li>Leather Care: Revitalize your leather shoes with our leather cleaning, conditioning, and polishing services. From scuff removal to color restoration, we handle it all.</li>
                <li>Customization: Make your shoes unique with our customization options. Add a personal touch with color accents, stitching patterns, and more.</li>
            </ul>
        </div>
        <div id="why-choose-us" class="section">
            <h2>Why Choose Us?</h2>
            <ul>
                <li>Quality Materials: We source only the finest materials for our repairs, ensuring durability and a perfect fit.</li>
                <li>Customer Satisfaction: Your satisfaction is our top priority. We strive to exceed your expectations with every repair.</li>
                <li>Environmentally Conscious: We believe in sustainability. Our repair services help reduce waste and extend the lifespan of your favorite footwear.</li>
            </ul>
        </div>
        <div id="visit-us" class="section">
            <h2>Visit Us</h2>
            <p>Experience the difference at Jaru Shoe Repair. Visit our shop today to discover why we're Juja's trusted name in shoe repair. Our friendly staff is here to assist you with all your shoe care needs.</p>
        </div>
        <?php if ($isAdmin): ?>
            <div class="update-form">
                <form method="post" action="about_update.php">
                    <textarea name="about_text" rows="10" cols="50">Welcome to Jaru Shoe Repair, where craftsmanship meets care. With decades of experience in the art of shoe mending, we take pride in restoring your favorite footwear to its former glory. Located in the heart of Juja's, our shop is a haven for shoe enthusiasts who value both style and durability.

Our Mission
At Jaru Shoe Repair, our mission is simple yet profound: to breathe new life into every pair of shoes that comes through our door. Whether it's a beloved pair of heels, dress shoes, or casual sneakers, each shoe is treated with meticulous attention to detail and respect for its unique history.

Expert Craftsmanship
Our team of skilled cobblers brings a wealth of knowledge and expertise to every repair. From replacing worn-out soles and heels to intricate stitching and leather restoration, we use traditional techniques combined with modern tools to ensure the highest quality craftsmanship.

Services We Offer
Sole Replacement: Extend the life of your shoes with our expert sole replacement service. Choose from a range of durable materials to suit your needs.

Heel Repair: Restore stability and comfort with our professional heel repair services. We fix worn-down heels and ensure even wear for a smoother stride.

Leather Care: Revitalize your leather shoes with our leather cleaning, conditioning, and polishing services. From scuff removal to color restoration, we handle it all.

Customization: Make your shoes unique with our customization options. Add a personal touch with color accents, stitching patterns, and more.

Why Choose Us?
Quality Materials: We source only the finest materials for our repairs, ensuring durability and a perfect fit.

Customer Satisfaction: Your satisfaction is our top priority. We strive to exceed your expectations with every repair.

Environmentally Conscious: We believe in sustainability. Our repair services help reduce waste and extend the lifespan of your favorite footwear.

Visit Us
Experience the difference at Jaru Shoe Repair. Visit our         echo 'shop today to discover why we\'re Juja\'s trusted name in shoe repair. Our friendly staff is here to assist you with all your shoe care needs.</textarea>
                    <button type="submit">Update</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Smooth scrolling using jQuery
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

        // Add animation for sections
        window.addEventListener('scroll', reveal);

        function reveal() {
            var sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                var sectionTop = section.getBoundingClientRect().top;
                var windowHeight = window.innerHeight;
                if (sectionTop < windowHeight - 200) {
                    section.classList.add('show');
                }
            });
        }
    </script>
</body>
</html>




