<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

class End implements EndInterface
{
    /**
     * @var TimePointInterface
     */
    private $vt;

    /**
     * @var TimePointInterface
     */
    private $tt;

    protected function __construct()
    {
    }

    public static function create(TimePointInterface $vt, TimePointInterface $tt):EndInterface
    {
        $instance = new static();
        $instance->vt = $vt;
        $instance->tt = $tt;

        return $instance;
    }

    public static function deserialize(array $data):EndInterface
    {
        $vt = TimePoint::fromString($data['vt']);
        $tt = TimePoint::fromString($data['tt']);

        return self::create($vt, $tt);
    }

    public function getValidTime():TimePointInterface
    {
        return $this->vt;
    }

    public function getTransactionTime():TimePointInterface
    {
        return $this->tt;
    }

    public function serialize():array
    {
        return [
            'tt' => $this->tt->toString(),
            'vt' => $this->vt->toString(),
        ];
    }
}
