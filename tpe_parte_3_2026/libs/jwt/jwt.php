<?php

require_once __DIR__ . '/../../config.php';

//Convierte texto normal en formato Base64 URL Safe
function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

//hace lo opuesto a la funcion base64url_encode
function base64url_decode($data)
{
    return base64_decode(strtr($data, '-_', '+/'));
}

function createJWT($payload)
{
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    $header = base64url_encode(
        json_encode($header)
    );

    $payload = base64url_encode(json_encode($payload));

    $signature = base64url_encode(hash_hmac('sha256', $header . '.' . $payload, JWT_SECRET, true));

    return $header . '.' . $payload . '.' . $signature;
}

function validateJWT($jwt)
{
    $parts = explode('.', $jwt);

    if (count($parts) !== 3) {
        return null;
    }

    $header = $parts[0];
    $payload = $parts[1];
    $signature = $parts[2];

    $expectedSignature = base64url_encode(hash_hmac('sha256', $header . '.' . $payload, JWT_SECRET, true));

    if ($signature !== $expectedSignature) {
        return null;
    }

    $payload = json_decode(base64url_decode($payload));

    if (!$payload) {
        return null;
    }

    if (!isset($payload->exp)) {
        return null;
    }

    if ($payload->exp < time()) {
        return null;
    }

    return $payload;
}