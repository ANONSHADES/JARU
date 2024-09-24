<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SESSION['role'] == 'admin') {
    // Display booked services for admins
    $sql = "SELECT bs.id, bs.booking_number, bs.username, bs.email, bs.phone, s.name AS service_name, bs.status
            FROM booked_services bs
            INNER JOIN services s ON bs.service_id = s.id";
} else {
    // Display booked services for customers
    $username = sanitize($_SESSION['username']);
    $sql = "SELECT bs.id, bs.booking_number, bs.username, bs.email, bs.phone, s.name AS service_name, bs.status
            FROM booked_services bs
            INNER JOIN services s ON bs.service_id = s.id
            WHERE bs.username = ?";
}

// Prepare statement
$stmt = $conn->prepare($sql);

if ($_SESSION['role'] != 'admin') {
    // Bind parameter for username
    $stmt->bind_param('s', $username);
}

// Execute statement
$stmt->execute();

// Bind result variables
$stmt->bind_result($id, $booking_number, $username, $email, $phone, $service_name, $status);

// Fetch results
$booked_services = [];
while ($stmt->fetch()) {
    $booked_services[] = [
        'id' => $id,
        'booking_number' => $booking_number,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'service_name' => $service_name,
        'status' => $status
    ];
}

// Close statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        table th { background-color: #f2f2f2; }
        .fulfill-btn { padding: 8px 16px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .back-btn { display: inline-block; padding: 10px 20px; background-color: #ddd; color: #333; text-decoration: none; margin-top: 20px; }
        .back-btn:hover { background-color: #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo ($_SESSION['role'] == 'admin') ? 'Booked Services' : 'My Booked Services'; ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Booking Number</th>
                    <th>Service Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <?php if ($_SESSION['role'] == 'admin') : ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($booked_services as $service) : ?>
                    <tr>
                        <td><?php echo sanitize($service['booking_number']); ?></td>
                        <td><?php echo sanitize($service['service_name']); ?></td>
                        <td><?php echo sanitize($service['username']); ?></td>
                        <td><?php echo sanitize($service['email']); ?></td>
                        <td><?php echo sanitize($service['phone']); ?></td>
                        <td><?php echo sanitize($service['status']); ?></td>
                        <?php if ($_SESSION['role'] == 'admin' && $service['status'] == 'Pending') : ?>
                            <td>
                                <button class="fulfill-btn" onclick="markFulfilled(<?php echo $service['id']; ?>)">Fulfill</button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($booked_services)) : ?>
                    <tr><td colspan="7">No booked services found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <script>
   function markFulfilled(bookingId) {
    if (confirm('Mark this service as fulfilled?')) {
        fetch('fulfill_service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ booking_id: bookingId }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response from server:', data);
            alert(data.message);
            window.location.reload(); // Reload the page if necessary
        })
        .catch(error => console.error('Error:', error));
    }
}
    </script>
</body>
</html>





