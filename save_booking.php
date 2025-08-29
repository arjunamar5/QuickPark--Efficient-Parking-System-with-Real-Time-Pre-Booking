<?php
// Database configuration
$host = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "login"; // Your database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// Get JSON input from the request
$requestData = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($requestData['otp'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid input. OTP is required."
    ]);
    exit;
}

$otp = $requestData['otp'];

// Insert OTP into the irsensor table
$query = "INSERT INTO irsensor (OTP) VALUES (?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $otp);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "OTP saved successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save OTP: " . $stmt->error
    ]);
}

// Close the database connection
$stmt->close();
$conn->close();
?>
