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
require __DIR__ . '/middleware/auth_middleware.php'; // JWT auth

// Obtener ID del usuario desde el JWT
$userId = authenticateRequest(); // ← debe devolver un int o lanzar error si no es válido

// Obtener datos del cuerpo de la petición
$data = json_decode(file_get_contents("php://input"), true);

// Validación básica
$required = ['exercise_id', 'weight', 'reps', 'sets', 'notes'];
foreach ($required as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Falta el campo: $field"]);
        exit;
    }
}

try {
    $query = "INSERT INTO workout_sessions (exercise_id, date, weight, reps, sets, notes, user_id) 
              VALUES (:exercise_id, NOW(), :weight, :reps, :sets, :notes, :user_id)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'exercise_id' => $data['exercise_id'],
        'weight'      => $data['weight'],
        'reps'        => $data['reps'],
        'sets'        => $data['sets'],
        'notes'       => $data['notes'],
        'user_id'     => $userId
    ]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al guardar la sesión',
        'detalle' => $e->getMessage()
    ]);
}
