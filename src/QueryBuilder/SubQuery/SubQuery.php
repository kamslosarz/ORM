<?php

namespace Orm\QueryBuilder\SubQuery;

class SubQuery
{
    private static $separators = [
        'or' => ' OR ',
        'and' => ' AND ',
        ',' => ', '
    ];

    private $binds = [];
    private $subQuery = [];
    private $brackets = 0;

    public function __toString(): string
    {
        return implode('', $this->subQuery) . str_repeat(')', $this->brackets);
    }

    public function getBinds(): array
    {
        return $this->binds;
    }

    public function addSubQuery(string $query): self
    {
        $this->subQuery[] = $query;

        return $this;
    }

    public function addSeparator(string $separator): self
    {
        $this->subQuery[] = self::$separators[$separator];

        return $this;
    }

    public function pushBind($bind): self
    {
        $this->binds[] = $bind;

        return $this;
    }

    public function addBind($parameterName, $bindValue): self
    {
        $this->binds[$parameterName] = $bindValue;

        return $this;
    }

    public function inBracket(): self
    {
        $this->subQuery[] = '(';
        $this->brackets++;

        return $this;
    }

    public function endBrackets(int $count = null): self
    {
        if ($count === null) {
            $count = $this->brackets;
        }
        $this->subQuery[] = str_repeat(')', $count);
        $this->brackets -= $count;

        return $this;
    }

    public function pushBinds($binds = []): self
    {
        foreach ($binds as $bind) {
            $this->binds[] = $bind;
        }

        return $this;
    }

}