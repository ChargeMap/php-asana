<?php

namespace Asana\Errors;

class NoAuthorizationError extends AsanaError
{
    const MESSAGE = 'No Authorization';
    const STATUS = 401;

    public function __construct($response)
    {
        parent::__construct(self::MESSAGE, self::STATUS, $response);
    }
}
