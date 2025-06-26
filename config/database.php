<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

// require '../vendor/autoload.php'; // Para firebase/php-jwt


// $secret_key = getenv('SECRET_KEY'); // Cambia esto!
// $algorithm = 'HS256';

// // Conexión a DB (db_connection.php)
// $conn = mysqli_connect("localhost", "root", "", "gym_db");
// if (!$conn) die(json_encode(["error" => "Error de conexión: " . mysqli_connect_error()]));
$host = getenv('DB_HOST');      // Ej: db.xxxxx.supabase.co
$db   = getenv('DB_NAME');      // Ej: postgres
$user = getenv('DB_USER');      // Ej: postgres
$pass = getenv('DB_PASS');      // Tu contraseña
$port = getenv('DB_PORT');      // Generalmente 5432

$dsn = "pgsql:host=$host;port=$port;dbname=$db;";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Lanza excepciones en errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Resultados como array asociativo
        PDO::ATTR_EMULATE_PREPARES => false            // Desactiva emulación (más seguro)
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error de conexión a la base de datos',
        'detalle' => $e->getMessage()
    ]);
    exit;
}

// echo json_encode([
//     "message" => "Conexión exitosa a la base de datos",
//     "status" => "success"
// ]);