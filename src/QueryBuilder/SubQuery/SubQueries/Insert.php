<?php

namespace Orm\QueryBuilder\SubQuery\SubQueries;


use Orm\QueryBuilder\Query;
use Orm\QueryBuilder\SubQuery\SubQuery;

class Insert extends Query
{
    private $into;
    private $values;
    private $columns;

    public function into($into): self
    {
        $this->into = $into;

        return $this;
    }

    public function values(array $values): self
    {
        $this->values = $values;

        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    protected function getSubQuery(): SubQuery
    {
        $subQuery = (new SubQuery())
            ->addSubQuery(sprintf('INSERT INTO %s ', $this->into))
            ->inBracket()
            ->addSubQuery(implode(',', $this->columns))
            ->endBrackets()
            ->addSubQuery(' VALUES ');

        $valuesBindString = rtrim(str_repeat('?,', sizeof($this->columns)), ',');
        $count = sizeof($this->values) - 1;

        foreach ($this->values as $index => $value) {
            $subQuery->inBracket()
                ->addSubQuery($valuesBindString)
                ->endBrackets()
                ->pushBinds($value);
            if ($index < $count) {
                $subQuery->addSeparator(',');
            }
        }

        return $subQuery;
    }
}