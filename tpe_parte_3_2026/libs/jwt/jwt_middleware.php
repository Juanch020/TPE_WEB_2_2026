<?php
require_once __DIR__ . '/jwt.php';
require_once __DIR__ . '/../libs/router/middleware.php';

class JWTMiddleware extends Middleware
{
    public function run($request, $response)
    {
        $authHeader = $request->authorization;

        if (empty($authHeader)) {
            return $response->json([
                'error' => 'Token requerido'
            ], 401);
        }

        $parts = explode(' ', $authHeader);

        if (count($parts) !== 2 || $parts[0] !== 'Bearer') {
            return $response->json([
                'error' => 'Formato de token inválido'
            ], 401);
        }

        $jwt = $parts[1];

        $user = validateJWT($jwt);

        if (!$user) {
            return $response->json([
                'error' => 'Token inválido o expirado'
            ], 401);
        }

        $request->user = $user;
    }
}
?>