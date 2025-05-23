<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "dineplateshare");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Basic password check
if ($password !== $confirmPassword) {
    die("Passwords do not match.");
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO donors (fullName, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $fullName, $email, $hashedPassword);

if ($stmt->execute()) {
    echo "Registration successful! <br>Your coupon code: <strong>" . strtoupper(substr(md5(time()), 0, 6)) . "</strong>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
