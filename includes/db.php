<?php
// includes/db.php - PostgreSQL via Supabase for Vercel Serverless Functions
// Configure these in the Vercel project environment:
// - SUPABASE_URL
// - SUPABASE_DB_PASSWORD (the database password, not an API key)

$supabaseUrl = getenv('SUPABASE_URL') ?: 'https://lvpxlkyyawcirxlngvax.supabase.co';
$supabaseDbPassword = getenv('SUPABASE_DB_PASSWORD');
$supabaseApiHost = parse_url($supabaseUrl, PHP_URL_HOST);
$supabaseHost = $supabaseApiHost ? 'db.' . $supabaseApiHost : null;
$hasPgsqlDriver = extension_loaded('pdo_pgsql');

error_log(sprintf(
    'Supabase config: host=%s, database=postgres, username=postgres, password_set=%s, pdo_pgsql=%s',
    $supabaseHost ?: 'invalid',
    $supabaseDbPassword ? 'yes' : 'no',
    $hasPgsqlDriver ? 'yes' : 'no'
));

if (!$supabaseHost || !$supabaseDbPassword) {
    error_log('Supabase database connection is not configured.');
    http_response_code(500);
    die('Database connection is not configured.');
}

if (!$hasPgsqlDriver) {
    error_log('The pdo_pgsql PHP extension is unavailable in the deployment runtime.');
    http_response_code(500);
    die('PostgreSQL support is unavailable.');
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
    error_log(sprintf(
        'Supabase PDO connection failed: code=%s, message=%s',
        $e->getCode(),
        $e->getMessage()
    ));
    die("Database connection failed");
}