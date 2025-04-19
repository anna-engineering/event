<?php

namespace A\Event;

interface SignalInterface
{
    public function connect(callable $callback) : bool;

    public function disconnect(callable $callback) : bool;
}
