<?php

return (new \Orm\SchemaBuilder\SchemaBuilder())->addTable(
        \Orm\SchemaBuilder\Factory\SchemaFactory::createTable('users')
            ->setModelName('User')
            ->addColumn(
                \Orm\SchemaBuilder\Factory\SchemaFactory::createColumn('id')
                    ->setRequired(true)
                    ->setType('integer')
                    ->setAutoIncrement(true)
                    ->setPrimaryKey(true)
            )->addColumn(
                \Orm\SchemaBuilder\Factory\SchemaFactory::createColumn('username')
                    ->setRequired(true)
                    ->setType('varchar')
                    ->setSize(255)
                    ->setDefault('')
            )->addColumn(
                \Orm\SchemaBuilder\Factory\SchemaFactory::createColumn('password')
                    ->setRequired(true)
                    ->setType('varchar')
                    ->setSize(32)
                    ->setDefault('')
            )
    )->build();
