<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

interface ValueInterface extends BitemporalInterface
{
    /**
     * Factory method.
     */
    public static function create($value, TimePointInterface $vt, TimePointInterface $tt):ValueInterface;

    /**
     * @return mixed
     */
    public function getValue();
}
