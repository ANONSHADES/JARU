<?php
session_start();
require_once 'db.php'; // Include your database connection file

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403); // Forbidden
    die('Access Denied');
}

// Validate and sanitize input
$data = json_decode(file_get_contents('php://input'), true);
$booking_id = $data['booking_id'] ?? null;
if (!is_numeric($booking_id)) {
    http_response_code(400); // Bad request
    die('Invalid booking ID');
}

// Update status in the database
$sql = "UPDATE booked_services SET status = 'Fulfilled' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $booking_id);

if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Booking fulfilled successfully.'];
} else {
    $response = ['status' => 'error', 'message' => 'Failed to fulfill booking: ' . $conn->error];
}

$stmt->close();
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
