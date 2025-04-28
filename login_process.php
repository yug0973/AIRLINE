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
    $username_or_email = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    // Query to find user by username or email
    $sql = "SELECT * FROM users WHERE username='$username_or_email' OR email='$username_or_email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verify the password against the stored hash
        if (password_verify($password, $row["password"])) {
            // Authentication successful
            $_SESSION['username'] = $row["username"]; // Store username in session
            header("Location: flight_registration.html"); // Redirect to logged-in area
            exit();
        } else {
            // Incorrect password
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: login.html");
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "User not found.";
        header("Location: login.html");
        exit();
    }
}

mysqli_close($conn);
?>