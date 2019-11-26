<?php

namespace Orm\Repository\Mapper\ModelCollection;

use Orm\DatabaseConnection\Collection\Collection;
use Orm\Repository\Mapper\Model\ModelInterface;

class ModelCollection extends Collection implements ModelInterface
{
    public function __construct($collection = [])
    {
        parent::__construct($collection);
    }

    public function save(): bool
    {
        // TODO: Implement save() method.
    }

    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }
}