# Airline Reservation & Flight Management System

A web-based flight reservation and ticketing system built with HTML5, CSS3, JavaScript, PHP, MySQL, and Leaflet.js.

[![Language](https://img.shields.io/badge/Language-PHP%20%7C%20JavaScript%20%7C%20SQL-blue.svg)](https://www.php.net/)
[![Frontend](https://img.shields.io/badge/Frontend-HTML5%20%7C%20CSS3-orange.svg)](https://developer.mozilla.org/)
[![Database](https://img.shields.io/badge/Database-MySQL-4479A1.svg)](https://www.mysql.com/)
[![Maps](https://img.shields.io/badge/Maps-Leaflet.js-green.svg)](https://leafletjs.com/)
[![License](https://img.shields.io/badge/License-MIT-lightgrey.svg)](LICENSE)

---

## Overview

The Airline Reservation & Flight Management System is a full-featured travel portal for searching domestic flights, selecting seats, booking tickets, tracking flight paths on an interactive map, and managing passenger itineraries.

It provides a responsive frontend user interface connected to a PHP backend with MySQL persistence, supporting session-based authentication and secure credential hashing.

---

## Features

### 1. Flight Search and Booking Dashboard
- Search available flights by departure city, arrival destination, and departure date.
- Real-time display of flight numbers, departure times, duration, and seat pricing.
- Dynamic fare calculations based on passenger count and class selection.

### 2. Passenger Confirmation and Ticketing
- Step-by-step passenger detail entry and confirmation workflow (`book-flight.html`).
- Seat assignment, baggage selection, and meal preferences.
- Automated generation of booking reference IDs (PNR) and printable boarding passes.

### 3. Interactive Route and Flight Status Map
- Integrated Leaflet.js mapping interface (`flight-status.html`).
- Visualized domestic flight trajectories between major airport hubs (Mumbai, Delhi, Bengaluru, Hyderabad, Chennai).
- Interactive markers displaying departure, arrival, and distance coordinates.

### 4. Itinerary and Ticket Management
- Dedicated "My Tickets" section (`my-tickets.html`) for viewing active and previous reservations.
- Real-time booking status lookup and reservation cancellation options.

### 5. Curated Routes and Deals
- "Most Booked" section (`most-booked.html`) highlighting popular travel corridors, trending destinations, and promotional flight packages.

### 6. Customer Support Center
- Dedicated support desk (`customer-care.html`) with assistance forms, baggage policies, frequently asked questions, and emergency contact helplines.

### 7. User Authentication and Account Security
- User registration and login workflows (`signup.html`, `login.html`).
- Password hashing using PHP's native `password_hash()` and `password_verify()` (Bcrypt).
- Session-based state management (`$_SESSION`) and SQL injection mitigation via input sanitization and prepared statements.

---

## Tech Stack

| Layer | Technologies |
|---|---|
| **Frontend** | HTML5, CSS3, JavaScript (ES6+), Leaflet.js (OpenStreetMap) |
| **Backend** | PHP 7.4+ / 8.x |
| **Database** | MySQL / MariaDB |
| **Web Server Environment** | Apache (XAMPP, WampServer, or LAMP stack) |

---

## System Architecture and Database Schema

### Database Configuration

The system uses a relational database named `airline_db` (or `airline`). Below is the SQL schema required to initialize the database:

```sql
CREATE DATABASE IF NOT EXISTS airline_db;
USE airline_db;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Flights Table
CREATE TABLE IF NOT EXISTS Flights (
    flight_id INT AUTO_INCREMENT PRIMARY KEY,
    flight_number VARCHAR(20) NOT NULL,
    departure_city VARCHAR(50) NOT NULL,
    arrival_city VARCHAR(50) NOT NULL,
    departure_date DATE NOT NULL,
    departure_time TIME NOT NULL,
    arrival_time TIME NOT NULL,
    available_seats INT NOT NULL DEFAULT 60,
    price DECIMAL(10,2) NOT NULL DEFAULT 4500.00
);

-- 3. Bookings Table
CREATE TABLE IF NOT EXISTS Bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    flight_id INT NOT NULL,
    passenger_name VARCHAR(100) NOT NULL,
    passenger_count INT NOT NULL DEFAULT 1,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'CONFIRMED',
    FOREIGN KEY (flight_id) REFERENCES Flights(flight_id) ON DELETE CASCADE
);

-- Sample Flight Data
INSERT INTO Flights (flight_number, departure_city, arrival_city, departure_date, departure_time, arrival_time, available_seats, price) VALUES
('AI-101', 'Mumbai', 'Delhi', '2026-09-20', '08:00:00', '10:15:00', 45, 5200.00),
('6E-204', 'Delhi', 'Bengaluru', '2026-09-20', '11:30:00', '14:15:00', 30, 6100.00),
('SG-305', 'Bengaluru', 'Mumbai', '2026-09-21', '09:45:00', '11:30:00', 50, 4800.00),
('UK-402', 'Hyderabad', 'Chennai', '2026-09-22', '14:00:00', '15:15:00', 40, 3900.00),
('AI-509', 'Chennai', 'Delhi', '2026-09-22', '18:30:00', '21:15:00', 25, 7200.00);
```

---

## Directory Structure

```
AIRLINE/
├── README.md                   # Project documentation
├── styles.css                  # Global stylesheets, responsive layout, CSS variables
├── flight.jpg                  # Hero/banner flight imagery
├── flight_registration.html    # Main booking dashboard and flight search
├── flight_registration.js      # Search algorithms and card rendering logic
├── book-flight.html            # Booking confirmation and passenger form
├── my-tickets.html             # User ticket history and PNR management
├── flight-status.html          # Interactive Leaflet.js route map and flight tracking
├── most-booked.html            # Top travel routes and fare showcase
├── customer-care.html          # Helpdesk, FAQs, and support form
├── login.html                  # User login interface
├── signup.html                 # User registration interface
├── login_process.php           # Authentication, session initialization, verification
├── signup_process.php          # User registration and password hashing logic
└── flight_booking_php_file.php # API queries for flights, bookings, and seat deduction
```

---

## Installation and Setup

### 1. Prerequisites
- **XAMPP**, **WampServer**, or native **Apache + PHP 7.4+ + MySQL** stack.
- Modern web browser (Chrome, Firefox, Edge, Safari).

---

### 2. Clone the Repository
Clone the repository into your local web server root directory:

**For XAMPP on Windows:**
```bash
cd C:\xampp\htdocs
git clone https://github.com/yug0973/AIRLINE.git
```

**For WampServer:**
```bash
cd C:\wamp64\www
git clone https://github.com/yug0973/AIRLINE.git
```

**For Linux (LAMP):**
```bash
cd /var/www/html
git clone https://github.com/yug0973/AIRLINE.git
```

---

### 3. Setup the Database
1. Launch **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Open your browser and navigate to `http://localhost/phpmyadmin`.
3. Create a new database named `airline_db`.
4. Click on the **SQL** tab and paste the SQL script provided in the **Database Configuration** section above.
5. Click **Go** to execute and populate the tables.

---

### 4. Database Connection Settings
Ensure your local database credentials match those configured in the PHP files:

In `login_process.php`, `signup_process.php`, and `flight_booking_php_file.php`:
```php
$servername = "localhost";
$db_username = "root";     // Default XAMPP username
$db_password = "";         // Default XAMPP password is empty
$database = "airline_db";  // Database name
```

---

### 5. Launch the Application
Open your browser and navigate to:
```
http://localhost/AIRLINE/flight_registration.html
```

Or access the authentication portal first:
```
http://localhost/AIRLINE/login.html
```

---

## Key Modules and Workflow

1. **Authentication Flow:**
   - Unauthenticated users can register via `signup.html`.
   - `signup_process.php` checks for duplicate usernames/emails and inserts passwords hashed with `PASSWORD_DEFAULT`.
   - `login_process.php` verifies hashed passwords and establishes a PHP session.

2. **Search and Booking Flow:**
   - On `flight_registration.html`, select departure and arrival cities.
   - Click **Search Flights** to view matches with schedules and pricing.
   - Select **Book Now** to transfer flight details into `book-flight.html`.
   - Submit passenger information to create a reservation record.

3. **Flight Route Visualization:**
   - Open `flight-status.html` to view interactive flight paths rendered with Leaflet.js over OpenStreetMap tiles.

---

## License

This project is licensed under the [MIT License](LICENSE).
