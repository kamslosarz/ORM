<?php

class CollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructCollection()
    {
        $collection = new \Orm\DatabaseConnection\Collection\Collection([
            ['test' => 'value', 'test2' => 'value2']
        ]);

        $this->assertInstanceOf(\Orm\DatabaseConnection\Collection\Collection::class, $collection);
    }

    public function testShouldJsonSerializeObject()
    {
        $collection = new \Orm\DatabaseConnection\Collection\Collection([
            ['test' => 123],
        ]);

        $this->assertJsonStringEqualsJsonString('[{"test": 123}]', $collection->jsonSerialize());
    }

    public function testShouldCountObjects()
    {
        $collection = new \Orm\DatabaseConnection\Collection\Collection([
            ['test' => 123],
        ]);

        $this->assertCount(1, $collection);
    }

    public function testShouldConvertCollectionToArray()
    {
        $collection = new \Orm\DatabaseConnection\Collection\Collection([
            ['test' => 123],
            ['test' => 123],
            ['test' => 123],
            ['test' => 123]
        ]);

        $this->assertEquals([
            ['test' => 123],
            ['test' => 123],
            ['test' => 123],
            ['test' => 123]
        ], $collection->__toArray());
    }
}