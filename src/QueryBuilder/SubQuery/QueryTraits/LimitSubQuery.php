<?php

namespace Orm\QueryBuilder\SubQuery\QueryTraits;

use Orm\QueryBuilder\SubQuery\SubQuery;

trait LimitSubQuery
{
    private $limit = [];

    public function limit($start, $end): self
    {
        $this->limit = [$start, $end];

        return $this;
    }

    private function buildLimit(SubQuery &$subQuery): void
    {
        if ($this->hasLimit()) {
            $start = intval($this->limit[0]) ?? 0;
            $end = intval($this->limit[1]) ?? 0;
            $subQuery->addSubQuery(sprintf(' LIMIT %s, %s', $start, $end));
        }
    }

    private function hasLimit(): bool
    {
        return !empty($this->limit);
    }
}