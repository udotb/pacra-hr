<?php
declare(strict_types=1);

namespace application\services\jwt;

class JwtKey
{
    public function getKey()
    {
        $key = 'PriceWatch@v1';
        return $key;
    }
}

?>
