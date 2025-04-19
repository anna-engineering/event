<?php

/**
 * Represents a signal or event system that allows connecting and disconnecting callable functions,
 * and invoking all connected callables with a set of arguments.
 */

namespace A\Event;

/**
 * Implements a signal/slot mechanism to manage event-driven programming.
 * Allows connections and disconnections of callbacks to a signal and
 * invocation of all connected callbacks when the signal is emitted.
 */
class Signal implements SignalInterface
{
    /**
     * @var callable[]
     */
    protected array $statics = [];

    /**
     * @var \WeakMap
     */
    protected \WeakMap $dynamics;

    public function __construct()
    {
        $this->dynamics = new \WeakMap();
    }

    /**
     * @param callable $callback
     * @return bool
     */
    public function connect(callable $callback) : bool
    {
        if (is_array($callback) and is_object($callback[0]))
        {
            $this->dynamics[$callback[0]] = $callback[1];
        }
        else
        {
            $this->statics[static::callable_key($callback)] = $callback;
        }

        return true;
    }

    /**
     * @param callable $callback
     * @return bool
     */
    public function disconnect(callable $callback) : bool
    {
        if (is_array($callback) and is_object($callback[0]))
        {
            unset($this->dynamics[$callback[0]]);
        }
        else
        {
            unset($this->statics[static::callable_key($callback)]);
        }

        return true;
    }

    /**
     * @return void
     */
    public function __invoke() : void
    {
        $args = func_get_args();

        foreach ($this->statics as $callable)
        {
            call_user_func_array($callable, $args);
        }

        foreach ($this->dynamics as $object => $method)
        {
            call_user_func_array([$object, $method], $args);
        }
    }

    /**
     * @param callable $callable
     * @return string
     */
    protected static function callable_key(callable $callable) : string
    {
        if (is_array($callable))
        {
            if (is_object($callable[0]))
            {
                return spl_object_id($callable[0]) . ':' . $callable[1];
            }
            else
            {
                return $callable[0] . ':' . $callable[1];
            }
        }
        else if ($callable instanceof \Closure)
        {
            return spl_object_id($callable);
        }
        else if (is_string($callable))
        {
            return $callable;
        }

        throw new \InvalidArgumentException('Unsupported callable type');
    }
}
