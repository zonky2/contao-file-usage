<?php

namespace InspiredMinds\ContaoFileUsage\Result;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InspiredMinds\ContaoFileUsage\Result\Results;
use IteratorAggregate;
use Traversable;

/** 
 * Stores Results per UUID.
 */
class ResultsCollection implements IteratorAggregate, ArrayAccess, Countable
{
    /** 
     * @var array<string, Results>
     */
    private $results = [];

    public function mergeCollection(ResultsCollection $collection): self
    {
        foreach ($collection as $uuid => $results) {
            $this->addResults($uuid, $results);
        }

        return $this;
    }

    public function addResults(string $uuid, Results $results): self
    {
        if ($results->hasResults()) {
            if (!isset($this->results[$uuid])) {
                $this->results[$uuid] = new Results($uuid);
            }
    
            $this->results[$uuid]->addResults($results);
        }

        return $this;
    }

    /**
     * @return Traversable<string, Results>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->results);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->results[$offset]);
    }

    public function offsetGet($offset): ?Results
    {
        return $this->results[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (!$value instanceof Results) {
            throw new \InvalidArgumentException('Value is not Results instance.');
        }

        if (!$value->hasResults()) {
            return;
        }

        $this->results[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->results[$offset]);
    }

    public function count(): int
    {
        return count($this->results);
    }
}