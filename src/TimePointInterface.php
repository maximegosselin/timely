<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use DateTimeInterface;

interface TimePointInterface
{
    public static function now():TimePointInterface;

    public static function fromString(string $dateTimeString):TimePointInterface;

    public function equals(TimePointInterface $tp):bool;

    public function comesAfter(TimePointInterface $tp):bool;

    public function comesBefore(TimePointInterface $tp):bool;

    public function toDateTime():DateTimeInterface;

    public function toString():string;
}
