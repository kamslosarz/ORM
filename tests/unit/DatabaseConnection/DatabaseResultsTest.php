<?php

class DatabaseResultsTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructDatabaseResultsObject()
    {
        $results = [
            ['column' => 'value'],
            ['column' => 'value'],
            ['column' => 'value']
        ];

        $databaseResults = new \Orm\DatabaseConnection\DatabaseResults($results);

        $this->assertInstanceOf(\Orm\DatabaseConnection\DatabaseResults::class, $databaseResults);
        $this->assertInstanceOf(\Orm\DatabaseConnection\Collection\Collection::class, $databaseResults->getCollection());
        $this->assertEquals($results, $databaseResults->getCollection()->__toArray());
    }

    public function testShouldGetLastInsertId()
    {
        $databaseResults = new \Orm\DatabaseConnection\DatabaseResults();
        $databaseResults->setLastInsertId(1000);
        $this->assertEquals(1000, $databaseResults->getLastInsertId());
    }
}
