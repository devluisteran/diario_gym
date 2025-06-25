<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require '../config/database.php'; // Tu conexión a DB
require __DIR__ . '/middleware/auth_middleware.php'; // Middleware de autenticación

// api/get_muscle_groups.php
$userId = authenticateRequest();
$id = mysqli_real_escape_string($conn, $userId);
if (!$id) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$query = "SELECT workout_sessions.*,exercises.name as exercise FROM workout_sessions
LEFT JOIN exercises on workout_sessions.exercise_id = exercises.id
WHERE workout_sessions.user_id = ? and (workout_sessions.status is null or workout_sessions.status <> 2) ORDER BY date desc;";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la consulta a la base de datos']);
    exit;
}

echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));