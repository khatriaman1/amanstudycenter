<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_learning";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email and password from POST request
$email = $_POST['exampleInputEmail1'];
$password = $_POST['exampleInputPassword1'];

// Prepare and bind
$stmt = $conn->prepare("SELECT email, passwd FROM register1 WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();

// Store the result
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    // Bind result variables
    $stmt->bind_result($email_db, $password_db);

    // Fetch the result
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $password_db)) {
        // Password is correct, start a session
        $_SESSION['email'] = $email_db;

        // Redirect to home page
        header("Location: home.html");
        exit();
    } else {
        // Password is incorrect
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: login.html");
        exit();
    }
} else {
    // No user found with the given email
    $_SESSION['error'] = "Invalid email or password.";
    header("Location: login.html");
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
