<?php

namespace Orm\DatabaseConnection;

use Orm\DatabaseConnection\Adapter\PdoConnectionAdapter;
use Orm\DatabaseConnection\Adapter\PdoConnectionInterface;

class DatabaseConnection
{
    private $defaultConnection;
    private $default;
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function createDefaultConnection(): PdoConnectionInterface
    {
        return new PdoConnectionAdapter(new \PDO(...$this->default));
    }

    public function setDefault($default): self
    {
        $this->default = $this->config[$default];
        $this->defaultConnection = $this->createDefaultConnection();

        return $this;
    }

    public function getDefaultConnection(): PdoConnectionInterface
    {
        if (!$this->defaultConnection) {
            $this->setDefault($this->config['default']);
        }

        return $this->defaultConnection;
    }

    public function getDefault()
    {
        return $this->default;
    }
}