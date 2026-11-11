<?php
// includes/db.php - PostgreSQL via Supabase
// Update these values with your Supabase project credentials

$host = "lvpxlkyyawcirxlngvax.supabase.co";     // Your Supabase project host
$username = "postgres";                          // Default Supabase username
$password = "your-supabase-password-here";            // Your Supabase database password
$dbname = "postgres";                            // Default Supabase database name

// Debug mode - set to false in production
define('DEBUG_MODE', true);

try {
    $conn = new PDO(
        "pgsql:host=$host;dbname=$dbname;port=5432",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    // Debug: Log and output successful connection
    if (DEBUG_MODE) {
        $conn_info = "Database connection established successfully to Supabase PostgreSQL";
        error_log($conn_info);
        // Output for development visibility
        echo "<!-- Database connected to Supabase PostgreSQL -->";
    }

} catch (PDOException $e) {
    // Debug: Log the error details
    if (DEBUG_MODE) {
        error_log("Database connection failed: " . $e->getMessage());
    }
    die("Connection failed: " . $e->getMessage());
}