<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class TimePoint implements TimePointInterface
{
    const FORMAT_STRING = 'Y-m-d\TH:i:s.uP';

    /**
     * @var DateTime
     */
    protected $dateTime;

    private function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function now():TimePointInterface
    {
        $microtime = sprintf('%.6F', microtime(true));
        $tz = new DateTimeZone('UTC');

        return new static(DateTime::createFromFormat('U.u', $microtime), $tz);
    }

    public static function fromString(string $dateTimeString):TimePointInterface
    {
        return new static(new DateTime($dateTimeString));
    }

    public function toString():string
    {
        return $this->dateTime->format(self::FORMAT_STRING);
    }

    public function __toString():string
    {
        return $this->toString();
    }

    public function equals(TimePointInterface $tp):bool
    {
        return $this->toString() === $tp->toString();
    }

    public function comesAfter(TimePointInterface $tp):bool
    {
        return $this->toDateTime() > $tp->toDateTime();
    }

    public function comesBefore(TimePointInterface $tp):bool
    {
        return $this->toDateTime() < $tp->toDateTime();
    }

    public function toDateTime():DateTimeInterface
    {
        return DateTimeImmutable::createFromMutable($this->dateTime);
    }
}
