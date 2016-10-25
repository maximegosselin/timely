<?php
declare(strict_types = 1);

namespace MaximeGosselin\Timely\Test;

use Generator;
use MaximeGosselin\Timely\Stream;
use MaximeGosselin\Timely\BitemporalInterface;
use MaximeGosselin\Timely\TimePoint;
use PHPUnit_Framework_TestCase;

class StreamTest extends PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $stream = new Stream();

        $asOf = TimePoint::fromString('10:00');
        $asAt = TimePoint::fromString('11:00');
        $stream->update(123, $asOf, $asAt);

        $result = $stream->find(TimePoint::fromString('09:00'), TimePoint::fromString('10:00'));
        $this->assertFalse($result);

        $result = $stream->find(TimePoint::fromString('11:00'), TimePoint::fromString('12:00'));
        $this->assertInstanceOf(BitemporalInterface::class, $result);
    }

    public function testTransactions()
    {
        $stream = new Stream();
        $this->assertInstanceOf(Generator::class, $stream->transactions());
    }
}
