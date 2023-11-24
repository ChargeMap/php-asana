<?php

namespace Asana\Test;

use Httpful\Bootstrap;
use Httpful\Request;

class MockRequest extends Request
{
    public $dispatcher;

    public function __construct($dispatcher)
    {
        Bootstrap::init();
        $this->dispatcher = $dispatcher;
    }
    public function send()
    {
        return $this->dispatcher->responseForRequest($this);
    }
}
