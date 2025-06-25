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
require '../config/database.php'; // Tu conexión a DB

$data = json_decode(file_get_contents("php://input"), true);

// Validar y sanitizar
$email = mysqli_real_escape_string($conn, $data['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Email inválido']);
    exit();
}
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'El email ya está registrado']);
    exit();
}
$password = password_hash($data['password'], PASSWORD_BCRYPT);

// Insertar en DB
$query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
if (mysqli_query($conn, $query)) {
    $id = mysqli_insert_id($conn);
    $token = JwtService::generateToken($id);

    echo json_encode([
        'token' => $token,
        'expires_in' => 3600 // 1 hora
    ]);
    //echo json_encode(['success' => true]);
} else {
    http_response_code(400);
    echo json_encode(['error' => mysqli_error($conn)]);
}