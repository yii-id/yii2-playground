<?php

namespace app\classes;

use Firebase\JWT\JWT as FJWT;

/**
 * Description of Jwt
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Jwt extends \yii\base\Object
{
    public $secret;
    public $algorithm = 'HS256';

    /**
     *
     * @param array $payload
     * @return string
     */
    public function encode($payload)
    {
        return FJWT::encode($payload, $this->secret, $this->algorithm);
    }

    /**
     *
     * @param string $token
     * @return type
     */
    public function decode($token)
    {
        return FJWT::decode($token, $this->secret, [$this->algorithm]);
    }
}
