<?php

namespace Orm\QueryBuilder\SubQuery\QueryTraits;

use Orm\QueryBuilder\SubQuery\SubQuery;

trait LeftJoinSubQuery
{
    private $joins = [];

    public function join($from, $on): self
    {
        return $this->addJoin($from, $on);
    }

    public function addJoin($from, $on): self
    {
        $this->joins[] = [$from, $on];

        return $this;
    }

    private function buildJoins(SubQuery &$subQuery): void
    {
        if (!empty($this->joins)) {
            foreach ($this->joins as $join) {
                $subQuery->addSubQuery(sprintf(' LEFT JOIN (%s) ON (%s)', $join[0], $join[1]));
            }
        }
    }
}