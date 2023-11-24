<?php

namespace Asana\Errors;

class InvalidRequestError extends AsanaError
{
    const MESSAGE = 'Invalid Request';
    const STATUS = 400;

    public function __construct($response)
    {
        parent::__construct(self::MESSAGE, self::STATUS, $response);
    }
}
