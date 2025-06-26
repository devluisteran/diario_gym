<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require __DIR__ . '/services/JwtService.php';
require '../config/database.php'; // Define $pdo con conexión PDO

// Obtener y decodificar el JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validación básica
if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Email y password requeridos']);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email inválido']);
    exit;
}

try {
    // Verificar si el email ya está registrado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        http_response_code(400);
        echo json_encode(['error' => 'El email ya está registrado']);
        exit;
    }

    // Hashear contraseña y registrar usuario
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->execute([
        'email' => $email,
        'password' => $hashedPassword
    ]);

    $userId = $pdo->lastInsertId();
    $token = JwtService::generateToken($userId);

    echo json_encode([
        'token' => $token,
        'expires_in' => 3600
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al registrar el usuario',
        'detalle' => $e->getMessage()
    ]);
}
