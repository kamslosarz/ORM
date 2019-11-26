<?php

namespace Orm\QueryBuilder\SubQuery\QueryTraits;

use Orm\QueryBuilder\SubQuery\SubQuery;

trait WhereSubQuery
{
    private $where;
    private $binds;

    public function where($where, array $binds = []): self
    {
        $this->where[] = [$where, $binds];

        return $this;
    }

    public function orWhere($where, array $binds = []): self
    {
        $this->where[] = ['or', $where, $binds];

        return $this;
    }

    public function andWhere($where, array $binds = []): self
    {
        $this->where[] = ['and', $where, $binds];

        return $this;
    }

    private function buildWhere(SubQuery &$subQuery): void
    {
        if ($this->where) {
            $subQuery->addSubQuery(' WHERE ');
            foreach ($this->where as $condition) {
                if (sizeof($condition) === 3) {
                    $subQuery->addSeparator($condition[0]);
                    $subQuery->inBracket();
                    $subQuery->addSubQuery($condition[1]);
                    $this->addBinds($subQuery, $condition[2]);
                } else {
                    $subQuery->addSubQuery($condition[0]);
                    $this->addBinds($subQuery, $condition[1]);
                }
            }
            $subQuery->endBrackets();
        }
    }

    private function addBinds(SubQuery &$subQuery, array $binds): void
    {
        if (is_array($binds)) {
            foreach ($binds as $parameter => $value) {
                if (is_string($parameter)) {
                    $subQuery->addBind($parameter, $value);
                } else {
                    $subQuery->pushBind($value);
                }
            }
        }
    }
}