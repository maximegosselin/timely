<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use Generator;
use MaximeGosselin\Serializer\DeserializableInterface;
use MaximeGosselin\Serializer\SerializableInterface;
use MaximeGosselin\Serializer\Serializer;
use PDO;
use PDOException;

class Stream implements StreamInterface, SerializableInterface, DeserializableInterface
{
    /**
     * @var array
     */
    protected $history;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var TimePointInterface
     */
    protected $lastTransactionTime;

    public function __construct()
    {
        $this->history = [];
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec('CREATE TABLE records(TT TEXT, VT TEXT)');
        $this->pdo->exec('CREATE INDEX idx_tt ON records(TT ASC)');
        $this->pdo->exec('CREATE INDEX idx_vt ON records(VT DESC)');
    }

    public static function deserialize(array $data):StreamInterface
    {
        $instance = new static();
        foreach ($data as $element) {
            $instance->appendToHistory($element);
        }
        return $instance;
    }

    public function find(TimePointInterface $asAt, TimePointInterface $asOf)
    {
        $sql = 'SELECT * FROM records WHERE TT <= :tt AND VT <= :vt ORDER BY VT DESC, TT DESC LIMIT 1';
        $query = $this->pdo->prepare($sql);
        $query->execute([
            ':tt' => $asAt->toString(),
            ':vt' => $asOf->toString(),
        ]);

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $asAt = TimePoint::fromString($row['TT']);
            $asOf = TimePoint::fromString($row['VT']);
            $key = $this->resolveKey($asAt, $asOf);

            return $this->history[$key];
        }

        return false;
    }

    public function update($value, TimePointInterface $asOf, TimePointInterface $asAt = null)
    {
        $asAt = $asAt ?? TimePoint::now();
        $element = Value::create($value, $asOf, $asAt);
        $this->appendToHistory($element);
    }

    public function end(TimePointInterface $asOf, TimePointInterface $asAt = null)
    {
        $asAt = $asAt ?? TimePoint::now();
        $end = End::create($asOf, $asAt);
        $this->appendToHistory($end);
    }

    public function transactions():Generator
    {
        foreach ($this->history as $record) {
            yield $record;
        }
    }

    public function serialize():array
    {
        return $this->history;
    }

    /**
     * @throws TransactionTimeException
     */
    protected function appendToHistory(BitemporalInterface $element)
    {
        /* Ensure that transactions are recorded in chronological order */
        if ($this->lastTransactionTime && $element->getTransactionTime()->comesBefore($this->lastTransactionTime)) {
            throw new TransactionTimeException();
        }
        $this->lastTransactionTime = $element->getTransactionTime();

        $key = $this->resolveKey($element->getTransactionTime(), $element->getValidTime());
        $this->history[$key] = $element;

        $query = $this->pdo->prepare('INSERT INTO records (TT, VT) VALUES (:tt, :vt)');
        if (!$query) {
            throw new PDOException();
        }
        $query->execute([
            ':tt' => $element->getTransactionTime()->toString(),
            ':vt' => $element->getValidTime()->toString(),
        ]);
    }

    protected function resolveKey(TimePointInterface $asAt, TimePointInterface $asOf)
    {
        return sprintf('%s_%s', $asAt->toString(), $asOf->toString());
    }
}
