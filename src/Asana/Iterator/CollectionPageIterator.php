<?php

namespace Asana\Iterator;

class CollectionPageIterator extends PageIterator
{
    public $sync = null;
    private $options;

    protected function getInitial()
    {
        return $this->client->get($this->path, $this->query, $this->options);
    }

    protected function getNext()
    {
        $this->options['offset'] = $this->continuation->offset;
        return $this->client->get($this->path, $this->query, $this->options);
    }

    protected function getContinuation($result)
    {
        if (!empty($result->sync)) {
            $this->sync = $result->sync;
        }

        return $result->next_page ?? null;
    }
}
