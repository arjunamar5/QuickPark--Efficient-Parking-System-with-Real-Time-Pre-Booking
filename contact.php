<?php
// Database connection
$servername = "localhost"; // Change if your MySQL server is hosted elsewhere
$username = "root";        // Default username for XAMPP
$password = "";            // Default password for XAMPP (empty)
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['uname'];
    $password = $_POST['psswd'];

    // Hash the password for security
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into MySQL
    $sql = "INSERT INTO details (Username, Password)
            VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to dashboard.html
        header("Location: dashboard.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
