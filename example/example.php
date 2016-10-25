<?php
use MaximeGosselin\Serializer\Engine;
use MaximeGosselin\Timely\Stream;
use MaximeGosselin\Timely\TimePoint;
use MaximeGosselin\Timely\Value;

require '../vendor/autoload.php';

date_default_timezone_set('UTC');

$stream = new Stream();
$stream->update(10, TimePoint::fromString('07:00'), TimePoint::fromString('08:00'));
$stream->update(14, TimePoint::fromString('10:00'), TimePoint::fromString('09:00'));
$stream->update(8, TimePoint::fromString('06:00'), TimePoint::fromString('10:00'));
$stream->update(17, TimePoint::fromString('11:00'), TimePoint::fromString('11:00'));
$stream->update(15, TimePoint::fromString('10:00'), TimePoint::fromString('12:00'));
$stream->update(12, TimePoint::fromString('08:00'), TimePoint::fromString('13:00'));
$stream->end(TimePoint::fromString('12:00'), TimePoint::fromString('14:00'));

$record = $stream->find(TimePoint::fromString('13:05'), TimePoint::fromString('11:30'));

if ($record instanceOf Value) {
    $serialization = (new Engine())->serialize($record);
    echo json_encode($serialization, JSON_PRETTY_PRINT);
} else {
    echo 'Nothing found.';
}

