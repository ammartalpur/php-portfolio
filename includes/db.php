<?php
// VERCEL DEPLOYMENT WARNING:
// 'localhost' will NOT work on Vercel. You must use a REMOTE MySQL database provider 
// (e.g., Aiven, Clever Cloud, FreeMySQLHosting, or InfinityFree).

$servername = "your-remote-host.com";
$username = "your-remote-username";
$password = "your-remote-password";
$dbname = "your-remote-dbname";
$port = 3306; // Ensure the port matches your remote database provider

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
