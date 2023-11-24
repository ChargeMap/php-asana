<?php

namespace Asana\Errors;

class PremiumOnlyError extends AsanaError
{
    const MESSAGE = 'Payment Required';
    const STATUS = 402;

    public function __construct($response)
    {
        parent::__construct(self::MESSAGE, self::STATUS, $response);
    }
}
