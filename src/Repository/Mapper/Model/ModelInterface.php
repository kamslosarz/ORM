<?php

namespace Orm\Repository\Mapper\Model;

interface ModelInterface
{
    public function save(): bool;
    public function delete(): bool;
}