<?php

if (!function_exists('connect'))
{
    function connect(\A\Event\SignalInterface $signal, callable $callback) : bool
    {
        return $signal->connect($callback);
    }
}

if (!function_exists('disconnect'))
{
    function disconnect(\A\Event\SignalInterface $signal, callable $callback) : bool
    {
        return $signal->disconnect($callback);
    }
}
