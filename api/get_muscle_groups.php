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
if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

try {
    $query = "SELECT * FROM muscle_groups WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $userId]);
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($groups);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error en la consulta a la base de datos',
        'detalle' => $e->getMessage()
    ]);
}
