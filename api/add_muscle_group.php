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

$query = "INSERT INTO muscle_groups (name,user_id) 
          VALUES (?,?)";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "si", 
  $data['name'], 
  $userId);
mysqli_stmt_execute($stmt);
if (mysqli_stmt_error($stmt)) {
    echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
    exit;
}
echo json_encode(['success' => true,"id" => mysqli_insert_id($conn)]);