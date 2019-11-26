<?php

namespace Orm;

use Orm\DatabaseConnection\DatabaseConnection;
use Orm\Schema\Schema;

class Orm
{
    private static $config;
    private static $dataBaseConnection;
    private static $schema;

    public static function initialize($config)
    {
        self::$config = $config;
        self::initializeDatabaseConnection($config['driver']);
        self::initializeSchema($config['schema']);
    }

    private static function initializeDatabaseConnection($config): void
    {
        self::$dataBaseConnection = new DatabaseConnection($config);
    }

    private static function initializeSchema(array $config): void
    {
        self::$schema = new Schema(self::$config['schema'], $config['definition']);
    }

    public static function getDatabaseConnection(): DatabaseConnection
    {
        return self::$dataBaseConnection;
    }

    public static function getSchemaConfig(): array
    {
        return self::$config['schema'];
    }

    public static function getSchema(): Schema
    {
        return self::$schema;
    }
}