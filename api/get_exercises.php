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

$muscleGroupId = $_GET['muscle_group_id'] ?? null;
$query = "SELECT * FROM exercises" . ($muscleGroupId ? " WHERE muscle_group_id = $muscleGroupId" : "");
$result = mysqli_query($conn, $query);
echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));