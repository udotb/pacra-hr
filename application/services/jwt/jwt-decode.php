<?php
declare(strict_types=1);

namespace application\services\jwt;

use Firebase\JWT\JWT;
use Exception;

class JwtDecode
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function jwtDecode()
    {
        $jwtKey = new JwtKey();
        try {
            $value = JWT::decode($this->token, $jwtKey->getKey(), array('HS256'));
        } catch (Exception $e) {
            return $e;
        }
        return $value;
    }
}

?>
