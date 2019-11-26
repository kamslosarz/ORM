<?php

namespace Orm\SchemaBuilder\Table\Column;

class Column
{
    private $name;
    private $autoIncrement = false;
    private $type;
    private $primaryKey;
    private $required = false;
    private $size;
    private $default;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAutoIncrement($autoIncrement): self
    {
        $this->autoIncrement = $autoIncrement;

        return $this;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setPrimaryKey(bool $primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public function setRequired($required): self
    {
        $this->required = $required;

        return $this;
    }

    public function setSize($size): self
    {
        $this->size = $size;

        return $this;
    }

    public function setDefault($default): self
    {
        $this->default = $default;

        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function __toArray(): array
    {
        return [
            'name' => $this->name,
            'autoIncrement' => $this->autoIncrement,
            'type' => $this->type,
            'primaryKey' => $this->primaryKey,
            'required' => $this->required,
            'size' => $this->size,
        ];
    }
}