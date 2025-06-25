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

$data = json_decode(file_get_contents("php://input"), true);
$query = "INSERT INTO workout_sessions (exercise_id, date, weight, reps, sets, notes, user_id) 
          VALUES (?, NOW(), ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "idiisi", 
  $data['exercise_id'], 
  $data['weight'], 
  $data['reps'], 
  $data['sets'], 
  $data['notes'],
  $userId);
mysqli_stmt_execute($stmt);
echo json_encode(['success' => true]);