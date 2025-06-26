<?php
// api/login.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Manejar preflight (CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require __DIR__ . '/services/JwtService.php';
require '../config/database.php'; // Aquí se define $pdo (PDO PostgreSQL)

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener JSON y decodificarlo
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

// Validar entrada
if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Email y password requeridos']);
    exit;
}

// Consulta segura con prepared statement
try {
    $stmt = $pdo->prepare("SELECT user_id, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $data['email']]);
    $user = $stmt->fetch();

    if ($user && password_verify($data['password'], $user['password'])) {
        $token = JwtService::generateToken($user['user_id']);

        echo json_encode([
            'token' => $token,
            'expires_in' => 3600
        ]);
    } else {
        http_response_code(401);
        echo json_encode([
            'error' => 'Credenciales inválidas',
            'user' => $data['email']
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()]);
}
?>
