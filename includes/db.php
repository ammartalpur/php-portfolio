// includes/db.php - PostgreSQL via Supabase for Vercel Serverless Functions
// Database connection for Vercel deployment
// Secrets should be configured in Vercel dashboard as environment variables:
// - SUPABASE_PROJECT_REF
// - SUPABASE_SERVICE_ROLE_KEY
// - SUPABASE_DB_PASSWORD (optional)

$projectRef = getenv('SUPABASE_PROJECT_REF') ?: 'lvpxlkyyawcirxlngvax';
$serviceRoleKey = getenv('SUPABASE_SERVICE_ROLE_KEY') ?: 'your-supabase-password-here';

$host = "$projectRef.supabase.co";
$username = "postgres";
$password = $serviceRoleKey;
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
    // In production, you might want to return a meaningful error
    // instead of dying
    die("Database connection failed");