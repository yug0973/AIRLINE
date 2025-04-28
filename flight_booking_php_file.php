<?php
// Configuration
$servername = "localhost"; // Or 127.0.0.1
$username = "root"; // Your MySQL username (default for XAMPP)
$password = "";     // Your MySQL password (default is often blank in XAMPP)
$database = "airline"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get flight details
function getFlightDetails($conn, $flight_id) {
    $sql = "SELECT * FROM Flights WHERE flight_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Returns associative array
    } else {
        return null;
    }
}

// Function to get booking details
function getBookingDetails($conn, $booking_id) {
    $sql = "SELECT * FROM Bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Function to get passenger details from booking id.
function getPassengerDetails($conn, $booking_id)
{
    //join bookings and flights table to get flight details
    $sql = "SELECT b.passenger_name, b.passenger_count, f.departure_city, f.arrival_city, f.departure_date, f.departure_time
            FROM Bookings b
            JOIN Flights f ON b.flight_id = f.flight_id
            WHERE b.booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


// Function to create a new booking
function createBooking($conn, $flight_id, $passenger_name, $passenger_count) {
    $sql = "INSERT INTO Bookings (flight_id, passenger_name, passenger_count) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $flight_id, $passenger_name, $passenger_count); // "i" for integer, "s" for string

    if ($stmt->execute()) {
        return $conn->insert_id; // Returns the new booking ID
    } else {
        return false; // Indicates failure
    }
}

// Function to update available seats in the Flights table (Optional, but recommended)
function updateAvailableSeats($conn, $flight_id, $seats_to_deduct) {
    $sql = "UPDATE Flights SET available_seats = available_seats - ? WHERE flight_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $seats_to_deduct, $flight_id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// --- Example Usage ---

// Get flight details
if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];
    $flight = getFlightDetails($conn, $flight_id);

    if ($flight) {
        echo "<h3>Flight Details:</h3>";
        echo "<p>Flight ID: " . $flight['flight_id'] . "</p>";
        echo "<p>Departure City: " . $flight['departure_city'] . "</p>";
        echo "<p>Arrival City: " . $flight['arrival_city'] . "</p>";
        // ... display other details
    } else {
        echo "Flight not found.";
    }
}

// Get booking details
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $booking = getBookingDetails($conn, $booking_id);

    if ($booking) {
        echo "<h3>Booking Details:</h3>";
        echo "<p>Booking ID: " . $booking['booking_id'] . "</p>";
        echo "<p>Flight ID: " . $booking['flight_id'] . "</p>";
        echo "<p>Passenger Name: " . $booking['passenger_name'] . "</p>";
        echo "<p>Passenger Count: " . $booking['passenger_count'] . "</p>";
        // ... display other details
    } else {
        echo "Booking not found.";
    }
}

//Get Passenger Details
if (isset($_GET['passenger_booking_id'])) {
    $booking_id = $_GET['passenger_booking_id'];
    $passenger = getPassengerDetails($conn, $booking_id);
    if ($passenger) {
        echo "<h3>Passenger Details:</h3>";
        echo "<p>Passenger Name: " . $passenger['passenger_name'] . "</p>";
        echo "<p>Passenger Count: " . $passenger['passenger_count'] . "</p>";
        echo "<p>Departure City: " . $passenger['departure_city'] . "</p>";
        echo "<p>Arrival City: " . $passenger['arrival_city'] . "</p>";
        echo "<p>Departure Date: " . $passenger['departure_date'] . "</p>";
        echo "<p>Departure Time: " . $passenger['departure_time'] . "</p>";
    } else {
        echo "Passenger details not found for this booking.";
    }
}

// Create a new booking (Example)
if (isset($_POST['flight_id']) && isset($_POST['passenger_name']) && isset($_POST['passenger_count'])) {
    $flight_id = $_POST['flight_id'];
    $passenger_name = $_POST['passenger_name'];
    $passenger_count = $_POST['passenger_count'];

    $new_booking_id = createBooking($conn, $flight_id, $passenger_name, $passenger_count);
    if ($new_booking_id) {
        echo "New booking created successfully! Booking ID: " . $new_booking_id;
    } else {
        echo "Error creating booking.";
    }
}

$conn->close();
?>