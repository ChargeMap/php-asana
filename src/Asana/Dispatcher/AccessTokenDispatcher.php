<?php

namespace Asana\Dispatcher;

use Exception;

class AccessTokenDispatcher extends Dispatcher
{
    private $accessToken;

    public function __construct($accessToken)
    {
        parent::__construct();

        $this->accessToken = $accessToken;
    }

    protected function authenticate($request)
    {
        if ($this->accessToken == null) {
            throw new Exception("AccessTokenDispatcher: access token not set");
        }
        return $request->addHeader("Authorization", "Bearer " . $this->accessToken);
    }
}
