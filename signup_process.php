<?php
session_start();

// Database credentials (replace with your actual values)
$servername = "localhost";
$db_username = "root"; // Default XAMPP MySQL username
$db_password = "";     // Default XAMPP MySQL password
$database = "airline_db"; // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $db_username, $db_password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"]; // In a real application, hash this securely!
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Basic password hashing

    // Check if username or email already exists
    $check_sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['signup_error'] = "Username or email already exists.";
        header("Location: signup.html");
        exit();
    } else {
        // Insert new user data
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['signup_success'] = "Registration successful. You can now login.";
            header("Location: login.html");
            exit();
        } else {
            $_SESSION['signup_error'] = "Error during registration: " . mysqli_error($conn);
            header("Location: signup.html");
            exit();
        }
    }
}

mysqli_close($conn);
?>