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
require __DIR__ . '/middleware/auth_middleware.php'; // Valida el token y devuelve user_id

// Obtener el ID del usuario autenticado
$userId = authenticateRequest();
if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    $query = "
        SELECT 
            workout_sessions.*, 
            exercises.name AS exercise 
        FROM workout_sessions
        LEFT JOIN exercises ON workout_sessions.exercise_id = exercises.id
        WHERE workout_sessions.user_id = :user_id
          AND (workout_sessions.status IS NULL OR workout_sessions.status <> 2)
        ORDER BY workout_sessions.date DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $userId]);
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($sessions);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error en la consulta a la base de datos',
        'detalle' => $e->getMessage()
    ]);
}
