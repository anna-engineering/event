# Référence API

## Interface `A\Event\SignalInterface`

```php
interface SignalInterface
{
    /**
     * Enregistre un listener.
     *
     * @param callable $callback
     * @return bool
     */
    public function connect(callable $callback) : bool;

    /**
     * Désenregistre un listener.
     *
     * @param callable $callback
     * @return bool
     */
    public function disconnect(callable $callback) : bool;
}
```

## Classe `A\Event\Signal`

```php
use SplObjectStorage;

final class Signal implements SignalInterface
{
    protected array $statics;
    protected SplObjectStorage $dynamics;

    public function __construct() : void;
    public function connect(callable $callback) : bool;
    public function disconnect(callable $callback) : bool;
    public function __invoke(mixed ...$args) : void;
    protected static function callable_key(callable $c) : string;
}
```

