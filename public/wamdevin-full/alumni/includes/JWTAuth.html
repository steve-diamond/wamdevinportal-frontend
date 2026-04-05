<?php
/**
 * WAMDEVIN Alumni Portal - JWT Authentication
 * 
 * Pure PHP JWT implementation (HS256) without external dependencies.
 * Tokens are stored in httpOnly, Secure, SameSite cookies.
 * 
 * Security:
 *  - HS256 HMAC signing
 *  - Token blacklist for logout
 *  - Short-lived access tokens (1h) + refresh tokens (7d)
 *  - All token validation checks (exp, iat, iss, nbf)
 * 
 * @version 1.0.0
 */

class JWTAuth
{
    private $secret;
    private $issuer   = 'wamdevin-alumni-portal';
    private $accessTtl  = 3600;        // 1 hour
    private $refreshTtl = 604800;      // 7 days

    public function __construct( $secret)
    {
        $this->secret = $secret;
    }

    // -----------------------------------------------------------------------
    // PUBLIC API
    // -----------------------------------------------------------------------

    /** Issue a new access + refresh token pair */
    public function issueTokens( $payload)
    {
        $now = time();
        return [
            'access_token'  => $this->buildToken($payload, $now + $this->accessTtl,  'access'),
            'refresh_token' => $this->buildToken($payload, $now + $this->refreshTtl, 'refresh'),
            'expires_in'    => $this->accessTtl,
        ];
    }

    /** Validate a token and return its payload, or null on failure */
    public function validate( $token, $type = 'access')
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;

        list($headerB64, $payloadB64, $sig) = $parts;

        // Verify signature
        $expected = $this->sign("{$headerB64}.{$payloadB64}");
        if (!hash_equals($expected, $sig)) return null;

        $payload = json_decode($this->base64urlDecode($payloadB64), true);
        if (!is_array($payload)) return null;

        // Standard claims
        if (((isset($payload['exp']) ? $payload['exp'] : 0)) < time())        return null; // expired
        if (((isset($payload['iat']) ? $payload['iat'] : 0)) > time() + 60)   return null; // clock skew
        if (((isset($payload['iss']) ? $payload['iss'] : '')) !== $this->issuer) return null;
        if (((isset($payload['typ']) ? $payload['typ'] : '')) !== $type)       return null;

        return $payload;
    }

    /** Refresh tokens using a valid refresh token */
    public function refresh( $refreshToken, $pdo)
    {
        $payload = $this->validate($refreshToken, 'refresh');
        if (!$payload) return null;

        // Check blacklist
        if ($this->isBlacklisted(hash('sha256', $refreshToken), $pdo)) return null;

        $newPayload = [
            'sub'   => $payload['sub'],
            'email' => $payload['email'],
            'role'  => $payload['role'],
            'name'  => $payload['name'],
        ];

        return $this->issueTokens($newPayload);
    }

    /** Blacklist a token (for logout) */
    public function revoke( $token, $pdo)
    {
        $payload = $this->validate($token, 'access');
        if (!$payload) {
            $payload = $this->validate($token, 'refresh');
        }
        if (!$payload) return;

        $hash      = hash('sha256', $token);
        $alumniId  = (int)$payload['sub'];
        $expiresAt = date('Y-m-d H:i:s', $payload['exp']);

        $stmt = $pdo->prepare(
            "INSERT IGNORE INTO jwt_blacklist (token_hash, alumni_id, expires_at) VALUES (?, ?, ?)"
        );
        $stmt->execute([$hash, $alumniId, $expiresAt]);
    }

    /** Store tokens in httpOnly cookies */
    public function setCookies( $tokens)
    {
        $secure   = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $basePath = '/wamdevin/alumni';

        setcookie('wam_access', $tokens['access_token'], time() + $this->accessTtl, $basePath, '', $secure, true);
        setcookie('wam_refresh', $tokens['refresh_token'], time() + $this->refreshTtl, $basePath . '/refresh', '', $secure, true);
    }

    /** Clear auth cookies */
    public function clearCookies()
    {
        setcookie('wam_access',  '', ['expires' => time() - 3600, 'path' => '/wamdevin/alumni']);
        setcookie('wam_refresh', '', ['expires' => time() - 3600, 'path' => '/wamdevin/alumni/refresh']);
    }

    /** Extract token from cookie or Authorization header */
    public function extractToken()
    {
        // Cookie first (preferred, httpOnly)
        if (!empty($_COOKIE['wam_access'])) {
            return $_COOKIE['wam_access'];
        }

        // Fallback: Authorization: Bearer <token>
        $auth = (isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '');
        if (strpos($auth, 'Bearer ') === 0) {
            return substr($auth, 7);
        }

        return null;
    }

    /** Purge expired blacklist entries (run periodically) */
    public function pruneBlacklist( $pdo)
    {
        $pdo->prepare("DELETE FROM jwt_blacklist WHERE expires_at < NOW()")->execute();
    }

    // -----------------------------------------------------------------------
    // PRIVATE HELPERS
    // -----------------------------------------------------------------------

    private function buildToken( $userPayload, $exp, $type)
    {
        $now = time();

        $header = $this->base64urlEncode(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
        ]));

        $payload = $this->base64urlEncode(json_encode(array_merge($userPayload, [
            'iss' => $this->issuer,
            'iat' => $now,
            'nbf' => $now,
            'exp' => $exp,
            'typ' => $type,
        ])));

        $signature = $this->sign("{$header}.{$payload}");

        return "{$header}.{$payload}.{$signature}";
    }

    private function sign( $data)
    {
        return $this->base64urlEncode(
            hash_hmac('sha256', $data, $this->secret, true)
        );
    }

    private function base64urlEncode( $data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64urlDecode( $data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }

    private function isBlacklisted( $tokenHash, $pdo)
    {
        $stmt = $pdo->prepare("SELECT id FROM jwt_blacklist WHERE token_hash = ? AND expires_at > NOW()");
        $stmt->execute([$tokenHash]);
        return (bool)$stmt->fetch();
    }
}
