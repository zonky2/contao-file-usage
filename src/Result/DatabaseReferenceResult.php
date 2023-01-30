<?php

namespace InspiredMinds\ContaoFileUsage\Result;

class DatabaseReferenceResult implements DatabaseReferenceResultInterface
{
    private string $table;
    private string $field;
    private $id;

    public function __construct(string $table, string $field, $id = null)
    {
        $this->table = $table;
        $this->field = $field;
        $this->id = $id;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->table.'.'.$this->field.' (ID '.$this->id.')';
    }
}