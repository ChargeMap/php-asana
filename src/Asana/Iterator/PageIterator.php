<?php

namespace Asana\Iterator;

use Iterator;
use ReturnTypeWillChange;

abstract class PageIterator implements Iterator
{
    private $currentPageNumber;
    private $currentPage;
    public $continuation;
    private $count;
    private $pageSize;
    private $itemLimit;
    private $options;
    protected $query;
    protected $path;
    protected $client;

    abstract protected function getInitial();
    abstract protected function getNext();
    abstract protected function getContinuation($result);

    public function __construct($client, $path, $query, $options)
    {
        $this->client = $client;
        $this->path = $path;
        $this->query = $query;
        $this->options = array_merge($client->options, $options, array('full_payload' => true));

        $this->itemLimit = $this->options['item_limit'] ?? null;
        if ($this->itemLimit == null) {
            $this->itemLimit = INF;
        }

        $this->pageSize = $this->options['page_size'];
        $this->count = 0;

        $this->continuation = false;

        $this->currentPage = null;
        $this->currentPageNumber = 0;
    }

    #[ReturnTypeWillChange]
    public function rewind()
    {
        # Compute the limit from the page size, and remaining item limit
        $this->options['limit'] = min($this->pageSize, $this->itemLimit - $this->count);
        if ($this->options['limit'] == 0) {
            $this->currentPage = null;
        } else {
            $result = $this->getInitial();
            $this->continuation = $this->getContinuation($result);
            $data = $result->data ?? null;
            if ($data != null) {
                $this->count += count($data);
            }
            $this->currentPage = $data;
        }
    }

    #[ReturnTypeWillChange]
    public function next()
    {
        $this->currentPageNumber++;
        # Compute the limit from the page size, and remaining item limit
        $this->options['limit'] = min($this->pageSize, $this->itemLimit - $this->count);
        if ($this->continuation == null || $this->options['limit'] == 0) {
            $this->currentPage = null;
        } else {
            $result = $this->getNext();
            $this->continuation = $this->getContinuation($result);
            $data = $result->data ?? null;
            if ($data != null) {
                $this->count += count($data);
            }
            $this->currentPage = $data;
        }
    }

    #[ReturnTypeWillChange]
    public function valid()
    {
        return $this->currentPage !== null;
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return $this->currentPage;
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        return $this->currentPageNumber;
    }

    #[ReturnTypeWillChange]
    public function items()
    {
        return new ItemIterator($this);
    }
}
