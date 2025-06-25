<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require '../vendor/autoload.php'; // Para firebase/php-jwt


$secret_key = getenv('SECRET_KEY'); // Cambia esto!
$algorithm = 'HS256';

// Conexión a DB (db_connection.php)
$conn = mysqli_connect("localhost", "root", "", "gym_db");
if (!$conn) die(json_encode(["error" => "Error de conexión: " . mysqli_connect_error()]));

// echo json_encode([
//     "message" => "Conexión exitosa a la base de datos",
//     "status" => "success"
// ]);