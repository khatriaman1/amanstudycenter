<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "online_learning";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Check if username or email already exists
    $checkSql = "SELECT * FROM register1 WHERE username = ? OR email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Username or Email already exists"]);
    } else {
        $sql = "INSERT INTO register1 (name1, username, email, passwd, city, state1, zip) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $name, $username, $email, $password, $city, $state, $zip);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "You are now successfully registered!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    }

    $checkStmt->close();
}

$conn->close();
?>
