<?php
session_start();
require_once 'db.php'; // Include your database connection file

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Save testimonial to database if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_testimonial'])) {
    if (!isset($_SESSION['username'])) {
        // Handle if user is not logged in
        header("Location: login.php");
        exit();
    }

    // Sanitize user input
    $username = $_SESSION['username'];
    $testimonial = sanitizeInput($_POST['testimonial']);

    // Insert testimonial into database
    $sql = "INSERT INTO testimonials (username, testimonial) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $testimonial);
    if ($stmt->execute()) {
        // Testimonial added successfully
        $stmt->close();
        $conn->close();
        // Redirect to testimonials.php to avoid form resubmission on refresh
        header("Location: testimonials.php");
        exit();
    } else {
        // Error in SQL execution
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials</title>
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
            color: #333; /* Text color for testimonials */
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 800px;
        }
        .content h1 {
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Text shadow for title */
        }
        .content p {
            text-align: center;
            font-size: 18px;
            font-style: italic;
            margin-bottom: 20px;
        }
        .content ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }
        .content li {
            font-size: 16px;
            margin-bottom: 10px;
            border-left: 3px solid #333; /* Testimonial border color */
            padding-left: 10px;
        }
        .testimonial-form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .testimonial-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ddd;
            resize: vertical;
        }
        .testimonial-form button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .testimonial-form button:hover {
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
        <h1>Testimonials</h1>
        <p>Our customers love us!</p>
        <ul>
            <?php
            // Fetch testimonials from database and display
            $sql = "SELECT * FROM testimonials ORDER BY created_at DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li>"' . htmlspecialchars($row['testimonial']) . '" - ' . htmlspecialchars($row['username']) . '</li>';
                }
            } else {
                echo '<li>No testimonials yet.</li>';
            }
            ?>
        </ul>
        <div class="testimonial-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="testimonial">Share your experience:</label>
                <textarea id="testimonial" name="testimonial" rows="4" required></textarea>
                <button type="submit" name="submit_testimonial">Submit</button>
            </form>
        </div>
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

<?php
// Close database connection
$conn->close();
?>


