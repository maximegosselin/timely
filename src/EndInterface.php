<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

interface EndInterface extends BitemporalInterface
{
    /**
     * Factory method.
     */
    public static function create(TimePointInterface $vt, TimePointInterface $tt):EndInterface;
}
