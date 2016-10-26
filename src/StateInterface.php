<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

interface StateInterface extends BitemporalInterface
{
    /**
     * Factory method.
     */
    public static function create($state, TimePointInterface $vt, TimePointInterface $tt):StateInterface;

    /**
     * @return mixed
     */
    public function getState();
}
