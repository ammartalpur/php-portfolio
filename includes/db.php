<?php
// includes/db.php - PostgreSQL via Supabase for Vercel Serverless Functions
// Configure these in the Vercel project environment:
// - SUPABASE_URL
// - SUPABASE_DB_PASSWORD (the database password, not an API key)

$supabaseUrl = getenv('SUPABASE_URL') ?: 'https://lvpxlkyyawcirxlngvax.supabase.co';
$supabaseDbPassword = getenv('SUPABASE_DB_PASSWORD');
$supabaseHost = parse_url($supabaseUrl, PHP_URL_HOST);

if (!$supabaseHost || !$supabaseDbPassword) {
    error_log('Supabase database connection is not configured.');
    http_response_code(500);
    die('Database connection is not configured.');
}

$host = $supabaseHost;
$username = "postgres";
$password = $supabaseDbPassword;
$dbname = "postgres";

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
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed");
}