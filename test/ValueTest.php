<?php
declare(strict_types = 1);

namespace MaximeGosselin\Timely\Test;

use MaximeGosselin\Timely\TimePoint;
use MaximeGosselin\Timely\Value;
use PHPUnit_Framework_TestCase;

class ValueTest extends PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $vt = TimePoint::fromString('2001-01-01');
        $tt = TimePoint::fromString('2002-02-02');
        $value = 123;
        $v = Value::create($value, $vt, $tt);

        $this->assertInstanceOf(Value::class, $v);
        $this->assertSame($v->getValue(), $value);
        $this->assertSame($v->getValidTime(), $vt);
        $this->assertSame($v->getTransactionTime(), $tt);
    }

    public function testSerialize()
    {
        $vtString = '2001-01-01T01:01:01.123456-05:00';
        $ttString = '2002-02-02T02:02:02.123456-05:00';
        $vt = TimePoint::fromString($vtString);
        $tt = TimePoint::fromString($ttString);
        $value = 123;
        $v = Value::create($value, $vt, $tt);

        $serialization = $v->serialize();

        $this->assertArraySubset([
            'tt' => $ttString,
            'vt' => $vtString,
            'value' => 123
        ], $serialization);
    }

    public function testDeserialize()
    {
        $vtString = '2001-01-01T01:01:01.123456-05:00';
        $ttString = '2002-02-02T02:02:02.123456-05:00';
        $vt = TimePoint::fromString($vtString);
        $tt = TimePoint::fromString($ttString);
        $serialization = [
            'value' => ['type' => 'integer', 'payload' => 123],
            'tt' => $ttString,
            'vt' => $vtString
        ];

        $object = Value::deserialize($serialization);
        $this->assertEquals($object->getValue(), 123);
        $this->assertEquals($object->getTransactionTime(), $tt);
        $this->assertEquals($object->getValidTime(), $vt);
    }
}
