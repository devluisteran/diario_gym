<?php
// api/middleware/auth_middleware.php

require __DIR__ . '/../services/JwtService.php';

function authenticateRequest() {
    $headers = getallheaders();
    
    if (empty($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Token no proporcionado']);
        exit;
    }
    
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $response = JwtService::validateToken($token);
    if (!['status']) {
        http_response_code(401);
        echo json_encode(['error' => 'Token inválido o expirado', 'message' => $response['message']]);
        exit;
    }
    
    return JwtService::getUserIdFromToken($token);
}