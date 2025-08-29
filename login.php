<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change this as per your database setup
$password = "";     // Change this as per your database setup
$dbname = "login";  // Database name

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['pwd'];

    // Validate input
    if (empty($login) || empty($password)) {
        echo "Both fields are required.";
        exit();
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM details WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $login, $password);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the credentials are valid
    if ($row = $result->fetch_assoc()) {
        // Redirect to the dashboard if credentials are valid
        header("Location: dashboard.html");
        exit();
    } else {
        echo "Invalid username or password.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
