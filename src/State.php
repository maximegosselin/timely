<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use MaximeGosselin\Serializer\DeserializableInterface;
use MaximeGosselin\Serializer\SerializableInterface;
use MaximeGosselin\Serializer\Serializer;

class State implements StateInterface, SerializableInterface, DeserializableInterface
{
    /**
     * @var mixed
     */
    private $state;

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

    public static function create($state, TimePointInterface $vt, TimePointInterface $tt):StateInterface
    {
        $instance = new static();
        $instance->state = $state;
        $instance->vt = $vt;
        $instance->tt = $tt;

        return $instance;
    }

    public static function deserialize(array $data):StateInterface
    {
        $state = $data['state'];
        $vt = TimePoint::fromString($data['vt']);
        $tt = TimePoint::fromString($data['tt']);

        return self::create($state, $vt, $tt);
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
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
            'state' => $this->state
        ];
    }
}
