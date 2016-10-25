<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

interface BitemporalInterface
{
    public function getValidTime():TimePointInterface;

    public function getTransactionTime():TimePointInterface;
}
