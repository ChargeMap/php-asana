<?php

namespace Asana\Errors;

class ServerError extends RetryableAsanaError
{
    const MESSAGE = 'Server Error';
    const STATUS = 500;

    public function __construct($response)
    {
        parent::__construct(self::MESSAGE, self::STATUS, $response);
    }
}
