<?php

namespace A\Event;

final class EventDispatcher
{
    /**
     * @var callable[][]
     */
    private array $listeners = [];

    public function addEventListener(string $type, callable $listener) : void
    {
        $this->listeners[$type][] = $listener;
    }

    public function dispatchEvent(string $type, ...$arguments) : void
    {
        foreach ($this->listeners[$type] ?? [] as $listener)
        {
            ($listener)(...$arguments);
        }
    }

    public function instance() : static
    {
        static $instance = null;

        if ($instance === null)
        {
            $instance = new static();
        }

        return $instance;
    }
}
