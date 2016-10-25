<?php

declare(strict_types = 1);

namespace MaximeGosselin\Timely;

use MaximeGosselin\Serializer\Serializer;

class Value implements ValueInterface
{
    /**
     * @var mixed
     */
    private $value;

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

    public static function create($value, TimePointInterface $vt, TimePointInterface $tt):ValueInterface
    {
        $instance = new static();
        $instance->value = $value;
        $instance->vt = $vt;
        $instance->tt = $tt;

        return $instance;
    }

    public static function deserialize(array $data):ValueInterface
    {
        $value = Serializer::deserialize($data['value']);
        $vt = TimePoint::fromString($data['vt']);
        $tt = TimePoint::fromString($data['tt']);

        return self::create($value, $vt, $tt);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getValidTime():TimePointInterface
    {
        return $this->vt;
    }

    public function getTransactionTime():TimePointInterface
    {
        return $this->tt;
    }

    /**
     * @throws SerializationException
     */
    public function serialize():array
    {
        return [
            'tt' => $this->tt->toString(),
            'vt' => $this->vt->toString(),
            'value' => $this->value
        ];
    }
}
