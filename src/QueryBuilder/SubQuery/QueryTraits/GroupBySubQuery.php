<?php

namespace Orm\QueryBuilder\SubQuery\QueryTraits;


use Orm\QueryBuilder\SubQuery\SubQuery;

trait GroupBySubQuery
{
    private $groupBy;

    public function groupBy($groupBy): self
    {
        $this->groupBy[] = $groupBy;

        return $this;
    }

    public function addGroupBy($groupBy): self
    {
        $this->groupBy[] = $groupBy;

        return $this;
    }

    private function buildGroupBy(SubQuery &$subQuery)
    {
        if (!empty($this->groupBy)) {
            $subQuery->addSubQuery(' GROUP BY ');
            $count = count($this->groupBy);
            $index = 1;
            foreach ($this->groupBy as $groupBy) {
                $subQuery->addSubQuery($groupBy);
                if ($index++ < $count) {
                    $subQuery->addSeparator(',');
                }
            }
        }
    }
}