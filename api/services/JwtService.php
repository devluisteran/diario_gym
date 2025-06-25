<?php
// api/services/JwtService.php

require __DIR__ . '/../../vendor/autoload.php';

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

class JwtService {
    private static $config;
    
    public static function init() {
        self::$config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(getenv('SECRET_KEY')) // Cambia esto!
        );
    }
    
    public static function generateToken($userId): string {
        $now = new DateTimeImmutable();
        
        return self::$config->builder()
            ->issuedBy('https://tudominio.com') // Emisor
            ->permittedFor('https://tudominio.com') // Audiencia
            ->issuedAt($now)
            ->expiresAt($now->modify('+30 days')) // Expiración
            ->withClaim('uid', $userId) // Custom claim
            ->getToken(self::$config->signer(), self::$config->signingKey())
            ->toString();
    }
    
    public static function validateToken(string $jwt){
        try {
            $token = self::$config->parser()->parse($jwt);
            
            $constraints = [
                new IssuedBy('http://localhost/diario_gym'),
                new PermittedFor('http://localhost/diario_gym'),
                new SignedWith(self::$config->signer(), self::$config->verificationKey())
            ];
            
            self::$config->validator()->assert($token, ...$constraints);
            return ["status"=>!$token->isExpired(new DateTimeImmutable()), "message" => "Token válido"];
            
        } catch (Exception $e) {
            error_log('JWT Error: ' . $e->getMessage());
            return ["status"=> false, "message" => "Token inválido o expirado"];
        }
    }
    
    public static function getUserIdFromToken(string $jwt): ?int {
        try {
            $token = self::$config->parser()->parse($jwt);
            return $token->claims()->get('uid');
        } catch (Exception $e) {
            return null;
        }
    }
}

// Inicializar al cargar el archivo
JwtService::init();