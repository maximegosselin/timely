<?php
declare(strict_types = 1);

namespace MaximeGosselin\Timely\Test;

use MaximeGosselin\Timely\State;
use MaximeGosselin\Timely\TimePoint;
use PHPUnit_Framework_TestCase;

class StateTest extends PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $vt = TimePoint::fromString('2001-01-01');
        $tt = TimePoint::fromString('2002-02-02');
        $state = 123;
        $v = State::create($state, $vt, $tt);

        $this->assertInstanceOf(State::class, $v);
        $this->assertSame($v->getState(), $state);
        $this->assertSame($v->getValidTime(), $vt);
        $this->assertSame($v->getTransactionTime(), $tt);
    }

    public function testSerialize()
    {
        $vtString = '2001-01-01T01:01:01.123456-05:00';
        $ttString = '2002-02-02T02:02:02.123456-05:00';
        $vt = TimePoint::fromString($vtString);
        $tt = TimePoint::fromString($ttString);

        $state = State::create(123, $vt, $tt);

        $this->assertArraySubset([
            'tt' => $ttString,
            'vt' => $vtString,
            'state' => 123
        ], $state->serialize());
    }

    public function testDeserialize()
    {
        $vtString = '2001-01-01T01:01:01.123456-05:00';
        $ttString = '2002-02-02T02:02:02.123456-05:00';
        $vt = TimePoint::fromString($vtString);
        $tt = TimePoint::fromString($ttString);
        $serialization = [
            'state' => 123,
            'tt' => $ttString,
            'vt' => $vtString
        ];

        $object = State::deserialize($serialization);
        $this->assertEquals($object->getState(), 123);
        $this->assertEquals($object->getTransactionTime(), $tt);
        $this->assertEquals($object->getValidTime(), $vt);
    }
}
