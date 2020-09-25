<?php

namespace Parkwayprojects\PayWithBank3D\Exceptions;

use Exception;

class CouldNotProcess extends Exception
{
    public static function notSetSecretKey()
    {
        return new static('Please Your Secret Key Is Not Set In Your .env File');
    }

    public static function notSetPublicKey()
    {
        return new static('Please Your Public Key Is Not Set In Your .env File');
    }

    public static function notSetUrl()
    {
        return new static('Please Your Live Or Test URL Is Not Set In Your .env File');
    }

    public static function invalidTransaction($message)
    {
        return new static($message);
    }
}
