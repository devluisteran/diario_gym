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
require __DIR__ . '/middleware/auth_middleware.php'; // Devuelve user_id si el token es válido

$userId = authenticateRequest(); // Aunque no se use directamente aquí, valida el acceso

try {
    $muscleGroupId = $_GET['muscle_group_id'] ?? null;

    if ($muscleGroupId !== null) {
        $query = "SELECT * FROM exercises WHERE muscle_group_id = :muscle_group_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['muscle_group_id' => $muscleGroupId]);
    } else {
        $query = "SELECT * FROM exercises";
        $stmt = $pdo->query($query);
    }

    $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($exercises);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al obtener los ejercicios',
        'detalle' => $e->getMessage()
    ]);
}
