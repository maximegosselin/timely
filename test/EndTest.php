<?php
declare(strict_types = 1);

namespace MaximeGosselin\Timely\Test;

use MaximeGosselin\Timely\End;
use MaximeGosselin\Timely\TimePoint;
use PHPUnit_Framework_TestCase;

class EndTest extends PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $vt = TimePoint::fromString('2001-01-01');
        $tt = TimePoint::fromString('2002-02-02');
        $v = End::create($vt, $tt);

        $this->assertInstanceOf(End::class, $v);
        $this->assertSame($v->getValidTime(), $vt);
        $this->assertSame($v->getTransactionTime(), $tt);
    }

    public function testSerialize()
    {
        $vtString = '2001-01-01T01:01:01.123456-05:00';
        $ttString = '2002-02-02T02:02:02.123456-05:00';
        $vt = TimePoint::fromString($vtString);
        $tt = TimePoint::fromString($ttString);
        $v = End::create($vt, $tt);

        $serialization = $v->serialize();

        $this->assertArraySubset([
            'tt' => $ttString,
            'vt' => $vtString
        ], $serialization);
    }

    public function testDeserialize()
    {
        $vtString = '2001-01-01T01:01:01.123456-05:00';
        $ttString = '2002-02-02T02:02:02.123456-05:00';
        $vt = TimePoint::fromString($vtString);
        $tt = TimePoint::fromString($ttString);
        $serialization = [
            'tt' => $ttString,
            'vt' => $vtString
        ];

        $object = End::deserialize($serialization);
        $this->assertEquals($object->getTransactionTime(), $tt);
        $this->assertEquals($object->getValidTime(), $vt);
    }
}
