<?php
// api/login.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Manejar la solicitud OPTIONS (preflight) primero
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require __DIR__ . '/services/JwtService.php';
require '../config/database.php'; // Tu conexión a DB

// Solo permitir método POST después de OPTIONS
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener y validar el JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

// Validación básica
if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Email y password requeridos']);
    exit;
}

// Buscar usuario en DB (MEJORADO: usar sentencias preparadas para seguridad)
$email = mysqli_real_escape_string($conn, $data['email']);
$query = "SELECT user_id, password FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la consulta a la base de datos']);
    exit;
}

$user = mysqli_fetch_assoc($result);
if ($user && password_verify($data['password'], $user['password'])) {
    $token = JwtService::generateToken($user['user_id']);

    echo json_encode([
        'token' => $token,
        'expires_in' => 3600 // 1 hora
    ]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Credenciales inválidas',"user" => $user['email'] ?? '']);
}

// Cerrar conexión
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>