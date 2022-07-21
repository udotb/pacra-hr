<?php
declare(strict_types=1);

namespace application\services\jwt;

use Firebase\JWT\JWT;

class JwtConfig
{
    private $expiryAllowed;
    private $issueTime;
    private $expireTime;

    public function __construct(bool $expiryAllowed = false, int $expireTimeInMinutes = 0)
    {
        $this->expiryAllowed = $expiryAllowed;
        if ($this->expiryAllowed) {
            $this->issueTime = time();
            $this->expireTime = $this->issueTime + $expireTimeInMinutes * 60;
        }
    }

    public function generateJWT($data)
    {
        $dataToEncode = ['data' => $data];
        if ($this->expiryAllowed) {
            $dataToEncode = [
                'data' => $data,
                'issueTime' => $this->issueTime,
                'expireTime' => $this->expireTime,
            ];
        }
        $getKey = new JwtKey();
        $key = $getKey->getKey();
        $jwt = JWT::encode($dataToEncode, $key);
        return $jwt;
    }
}

?>
