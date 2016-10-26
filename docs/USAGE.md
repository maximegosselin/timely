# Documentation

## The `Stream` class

The `Stream` class represents an history of states for an entity over time.
It can track changes and return the recorded state at a specific point in time, be it past, present or future.

Let's initialize a stream to record the outside temperature:

```php
$temperature = new Stream();
```

Now that we have our stream defined, we want to record the temperature observed during the day.

For that, we will use the `update` function each time we want to record a state change. This function takes 3 parameters:

- `$value` The state that we want to record. This can be anything of interest and in that example, it's an integer representing the temperature in Celsius.
- `TimePointInterface $asOf` The time at which the state was effective (*Valid Time* or *VT*).
- `TimePointInterface $asAt` (optional) The time at which the state was recorded in the system (*Transaction Time* or *VT*).

If `$asAt` is not provided, *Timely* will use the current system time.

Let's say that the temperature at 7AM this morning was 18C and we recorded that fact at 8AM.

```php
$stream->update(18, TimePoint::fromString('07:00'), TimePoint::fromString('08:00'));
```

Most of the time, you will not provide the `$asAt` parameter because you will want to record the fact as soon as it is reported in your application.


## The `TimePoint` class

In the previous example, we used the `TimePoint` class to define time.

`TimePoint` instances are created with `now` or `fromString` static functions.
 
```php
$tp = TimePoint::now();
$tp = TimePoint::fromString('2016-10-26 10:35:24');
```

The `fromString` function takes as a parameter any time string supported by PHP `DateTime`.

You can convert a `TimePoint` object to a `DateTimeImmutable`:

```php
$dt = (TimePoint::now())->toDateTime();
```


## Search

Let's say that we have been recording temperature all day and we want to know what was the temperature at 7:25, as the system knew it at 10:05.

```php
$asAt = TimePoint::fromString('10:05');
$asOf = TimePoint::fromString('07:25');
 
$state = $stream->find($asAt, $asOf);
```


## Iterating over states

```php
foreach($stream->states() as $transaction) {
    /* ... */
}
```
