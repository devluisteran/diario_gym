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
require __DIR__ . '/middleware/auth_middleware.php'; // Devuelve $userId desde JWT

$userId = authenticateRequest();

$data = json_decode(file_get_contents("php://input"), true);

// Validar que venga el ID
if (empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de sesión requerido']);
    exit;
}

try {
    $query = "UPDATE workout_sessions SET status = 2 WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'id' => $data['id'],
        'user_id' => $userId
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al actualizar la sesión',
        'detalle' => $e->getMessage()
    ]);
}
