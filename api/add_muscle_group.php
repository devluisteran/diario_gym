<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require '../config/database.php'; // Define $pdo
require __DIR__ . '/middleware/auth_middleware.php'; // Autenticación JWT

$userId = authenticateRequest();

$data = json_decode(file_get_contents("php://input"), true);

// Validación básica
if (empty($data['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'El campo name es requerido']);
    exit;
}

try {
    $query = "INSERT INTO muscle_groups (name, user_id) VALUES (:name, :user_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'name' => $data['name'],
        'user_id' => $userId
    ]);

    // Obtener el ID insertado (solo si la tabla tiene SERIAL/IDENTITY)
    $newId = $pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'id' => $newId
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error al insertar grupo muscular',
        'detalle' => $e->getMessage()
    ]);
}
