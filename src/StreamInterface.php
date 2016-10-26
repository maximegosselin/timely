<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use Generator;

interface StreamInterface
{
    public function find(TimePointInterface $asAt, TimePointInterface $asOf);

    /**
     * @throws TransactionTimeException If the transaction time comes before the last transaction
     */
    public function update($state, TimePointInterface $asOf, TimePointInterface $asAt = null);

    /**
     * @throws TransactionTimeException If the stream has already ended
     */
    public function end(TimePointInterface $asOf, TimePointInterface $asAt = null);

    public function transactions():Generator;
}
