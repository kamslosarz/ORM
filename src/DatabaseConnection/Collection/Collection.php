<?php

namespace Orm\DatabaseConnection\Collection;

class Collection implements \Iterator, \Countable, \JsonSerializable
{
    protected $collection = [];

    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    public function count()
    {
        return count($this->collection);
    }

    public function jsonSerialize()
    {
        return json_encode($this->collection);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    public function __toArray()
    {
        return (array) $this->collection;
    }

    public function current()
    {
        return current($this->collection);
    }

    public function next()
    {
        return next($this->collection);
    }

    public function key()
    {
        return key($this->collection);
    }

    public function valid()
    {
        return key($this->collection) !== null;
    }

    public function rewind()
    {
        return reset($this->collection);
    }

    public function first()
    {
        return $this->getIterator()->offsetGet(0);
    }
    public function last()
    {
        $iterator = $this->getIterator();

        return $iterator->offsetGet($iterator->count()-1);
    }
}