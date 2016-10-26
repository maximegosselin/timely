# Timely

[![Latest Version](https://img.shields.io/github/release/maximegosselin/timely.svg)](https://github.com/maximegosselin/timely/releases)
[![Build Status](https://img.shields.io/travis/maximegosselin/timely.svg)](https://travis-ci.org/maximegosselin/timely)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

*Timely* is a simple PHP library to manipulate bitemporal data.

For an introduction to bitemporal data, read [this article](http://martinfowler.com/eaaDev/timeNarrative.html).


## System Requirements

- PHP 7.0 or later
- PDO_SQLite extension for in-memory SQL queries


## Install

Install *Timely* using Composer.

```
$ composer require maximegosselin/timely
```

*Timely* is registered under the `MaximeGosselin\Timely` namespace.


## Usage

Declare a bitemporal stream:
```php
$stream = new Stream();
```

Set values over time:
```php
$stream->update(10, TimePoint::fromString('07:00'), TimePoint::fromString('08:00'));
$stream->update(8, TimePoint::fromString('09:30'), TimePoint::fromString('10:00'));
$stream->end(TimePoint::fromString('11:00'), TimePoint::fromString('12:00'));
```

Search with transaction time (*as at*) and valid time (*as of*):
```php
$record = $stream->find(TimePoint::fromString('10:05'), TimePoint::fromString('07:25'));

echo $record->getValue(); /* 10 */
```


## Tests

Run the following command from the project folder.
```
$ vendor/bin/phpunit
```


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
