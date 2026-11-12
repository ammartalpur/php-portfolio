<?php
// includes/db.php - PostgreSQL via Supabase for Vercel Serverless Functions
// Configure these in the Vercel project environment:
// - SUPABASE_URL
// - SUPABASE_DB_PASSWORD (the database password, not an API key)

$supabaseUrl = getenv('SUPABASE_URL') ?: 'https://lvpxlkyyawcirxlngvax.supabase.co';
$supabaseDbPassword = getenv('SUPABASE_DB_PASSWORD');
$supabaseApiHost = parse_url($supabaseUrl, PHP_URL_HOST);
$supabaseHost = getenv('SUPABASE_DB_HOST') ?: ($supabaseApiHost ? 'db.' . $supabaseApiHost : null);
$supabasePort = getenv('SUPABASE_DB_PORT') ?: '5432';
$supabaseUser = getenv('SUPABASE_DB_USER') ?: 'postgres';
$hasPgsqlDriver = extension_loaded('pdo_pgsql');

error_log(sprintf(
    'Supabase config: host=%s, port=%s, database=postgres, username=%s, password_set=%s, pdo_pgsql=%s',
    $supabaseHost ?: 'invalid',
    $supabasePort,
    $supabaseUser,
    $supabaseDbPassword ? 'yes' : 'no',
    $hasPgsqlDriver ? 'yes' : 'no'
));

function reportDatabaseError(string $message): void
{
    error_log($message);

    if (getenv('APP_DEBUG') === 'true') {
        echo '<script>console.error(' . json_encode($message) . ');</script>';
    }
}

if (!$supabaseHost || !$supabaseDbPassword) {
    reportDatabaseError('Supabase database connection is not configured.');
    http_response_code(500);
    die('Database connection is not configured.');
}

if (!$hasPgsqlDriver) {
    reportDatabaseError('The pdo_pgsql PHP extension is unavailable in the deployment runtime.');
    http_response_code(500);
    die('PostgreSQL support is unavailable.');
}

$host = $supabaseHost;
$port = $supabasePort;
$username = $supabaseUser;
$password = $supabaseDbPassword;
$dbname = "postgres";

try {
    $conn = new PDO(
        "pgsql:host=$host;dbname=$dbname;port=$port",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    reportDatabaseError(sprintf(
        'Supabase PDO connection failed: code=%s, message=%s',
        $e->getCode(),
        $e->getMessage()
    ));
    die("Database connection failed");
}