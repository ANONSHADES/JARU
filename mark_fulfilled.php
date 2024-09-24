<?php
session_start();

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $bookingId = filter_input(INPUT_POST, 'booking_id', FILTER_SANITIZE_NUMBER_INT);

    // Include database connection
    include 'db.php';

    // Prepare update query
    $sql = "UPDATE booked_services SET status = 'Finished' WHERE id = ?";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bookingId);

    // Execute statement
    if ($stmt->execute()) {
        // Return success message as JSON response
        $response = ['status' => 'success', 'message' => 'Service marked as fulfilled.'];
        echo json_encode($response);
    } else {
        // Return error message as JSON response
        $response = ['status' => 'error', 'message' => 'Failed to mark service as fulfilled.'];
        echo json_encode($response);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
?>


