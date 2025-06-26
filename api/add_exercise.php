<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require '../config/database.php'; // Define $pdo (conexión PostgreSQL)
require __DIR__ . '/middleware/auth_middleware.php'; // Autenticación JWT

$userId = authenticateRequest();

$data = json_decode(file_get_contents("php://input"), true);

// Validación básica
if (empty($data['name']) || empty($data['muscle_group_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos requeridos']);
    exit;
}

try {
    $query = "INSERT INTO exercises (name, muscle_group_id, user_id) 
              VALUES (:name, :muscle_group_id, :user_id)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'name' => $data['name'],
        'muscle_group_id' => $data['muscle_group_id'],
        'user_id' => $userId
    ]);

    echo json_encode([
        'success' => true,
        'id' => $pdo->lastInsertId()
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al insertar ejercicio',
        'detalle' => $e->getMessage()
    ]);
}
