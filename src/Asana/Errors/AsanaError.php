<?php

namespace Asana\Errors;

use Exception;

class AsanaError extends Exception
{
    public $response;
    public $status;

    public function __construct($message, $status, $response)
    {
        $this->message = $message;
        $this->status = $status;
        $this->response = $response;
    }

    public static function handleErrorResponse($response)
    {
        switch ($response->code) {
            case ForbiddenError::STATUS:
                throw new ForbiddenError($response);
            case InvalidRequestError::STATUS:
                throw new InvalidRequestError($response);
            case InvalidTokenError::STATUS:
                throw new InvalidTokenError($response);
            case NoAuthorizationError::STATUS:
                throw new NoAuthorizationError($response);
            case NotFoundError::STATUS:
                throw new NotFoundError($response);
            case PremiumOnlyError::STATUS:
                throw new PremiumOnlyError($response);
            case RateLimitEnforcedError::STATUS:
                throw new RateLimitEnforcedError($response);
            case ServerError::STATUS:
                throw new ServerError($response);
        }
    }
}
