<?php
declare(strict_types = 1);

namespace MaximeGosselin\Timely\Test;

use DateTimeImmutable;
use MaximeGosselin\Timely\TimePoint;
use PHPUnit_Framework_TestCase;

class TimePointTest extends PHPUnit_Framework_TestCase
{
    public function testNow()
    {
        $tp = TimePoint::now();
        $this->assertGreaterThan(0, $tp->toDateTime()->format('u'));
    }

    public function testFromString()
    {
        $string = '2000-01-01T01:02:03.123456-05:00';
        $tp = TimePoint::fromString($string);
        $this->assertInternalType('string', $tp->toString());
        $this->assertEquals($tp->toString(), $string);
    }

    public function testEquals()
    {
        $tp1 = TimePoint::fromString('2000-01-01T01:02:03.123456-05:00');
        $tp2 = TimePoint::fromString('2000-01-01T01:02:03.123456-05:00');
        $tp3 = TimePoint::fromString('2001-01-01T01:02:03.123456-05:00');

        $this->assertTrue($tp1->equals($tp2));
        $this->assertTrue($tp2->equals($tp1));
        $this->assertFalse($tp2->equals($tp3));
        $this->assertFalse($tp3->equals($tp2));
        $this->assertFalse($tp1->equals($tp3));
        $this->assertFalse($tp3->equals($tp1));
    }

    public function testComesAfter()
    {
        $tp1 = TimePoint::fromString('2000-01-01T01:02:03.123456-05:00');
        $tp2 = TimePoint::fromString('2000-01-01T01:02:03.123456-05:00');
        $tp3 = TimePoint::fromString('2001-01-01T01:02:03.123456-05:00');

        $this->assertFalse($tp1->comesAfter($tp2));
        $this->assertFalse($tp2->comesAfter($tp1));
        $this->assertFalse($tp2->comesAfter($tp3));
        $this->assertTrue($tp3->comesAfter($tp1));
    }

    public function testComesBefore()
    {
        $tp1 = TimePoint::fromString('2000-01-01T01:02:03.123456-05:00');
        $tp2 = TimePoint::fromString('2000-01-01T01:02:03.123456-05:00');
        $tp3 = TimePoint::fromString('2001-01-01T01:02:03.123456-05:00');

        $this->assertFalse($tp1->comesBefore($tp2));
        $this->assertFalse($tp2->comesBefore($tp1));
        $this->assertTrue($tp2->comesBefore($tp3));
        $this->assertFalse($tp3->comesBefore($tp1));
    }

    public function testToDateTime()
    {
        $string = '2000-01-01T01:02:03.123456-05:00';
        $tp = TimePoint::fromString($string);
        $this->assertInstanceOf(DateTimeImmutable::class, $tp->toDateTime());
        $this->assertEquals($tp->toDateTime()->format(TimePoint::FORMAT_STRING), $string);
    }
}
