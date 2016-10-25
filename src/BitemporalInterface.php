<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use MaximeGosselin\Serializer\SerializableInterface;

interface BitemporalInterface extends SerializableInterface
{
    public function getValidTime():TimePointInterface;

    public function getTransactionTime():TimePointInterface;
}
