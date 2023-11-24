<?php

namespace Asana\Test {

    use Asana\Client;
    use PHPUnit\Framework\TestCase;

    class AsanaTest extends TestCase
    {
        protected $client;

        protected function setUp(): void
        {
            global $sleepCalls;

            $this->dispatcher = new MockDispatcher();
            $this->client = new Client($this->dispatcher);
            $this->client->options['base_url'] = '';

            $sleepCalls = array();
        }
    }

}

// This is hacky way of mocking "sleep", since it's called within the Asana namespace we can redefine it.
namespace Asana {

    function sleep($time)
    {
        global $sleepCalls;
        $sleepCalls[] = $time;
    }

}
