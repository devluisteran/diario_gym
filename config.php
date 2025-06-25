<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require 'vendor/autoload.php'; // Para firebase/php-jwt
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "tu_clave_secreta_super_segura_2024"; // Cambia esto!
$algorithm = 'HS256';

// Conexión a DB (db_connection.php)
$conn = mysqli_connect("localhost", "usuario", "password", "gym_db");
if (!$conn) die(json_encode(["error" => "Error de conexión: " . mysqli_connect_error()]));