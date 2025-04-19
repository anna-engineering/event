<?php require '../vendor/autoload.php';

class Light
{
    public function __construct(protected(set) string $name = 'Light', protected(set) bool $state = false)
    {
    }

    public function toggle()
    {
        $this->state = !$this->state;
        echo "[EVENT] The light {$this->name} has been turned " . ($this->state ? 'on' : 'off') . PHP_EOL;
    }

    public function info()
    {
        echo "[ (I) ] The light {$this->name} is " . ($this->state ? 'on' : 'off') . PHP_EOL;
    }
}

class LightSwitch
{
    public \A\Event\SignalInterface $press;

    public function __construct(protected(set) string $name = 'LightSwitch')
    {
        $this->press = new \A\Event\Signal();
    }

    public function press()
    {
        echo "[EVENT] The switch {$this->name} got pressed" . PHP_EOL;
        ($this->press)();
    }
}

$light1 = new Light('Entrance Hall');
$light2 = new Light('Living Room');

$switch1 = new LightSwitch('Entrance Hall');
$switch2 = new LightSwitch('Living Room');
$switchD = new LightSwitch('Central');

$switch1->press->connect([$light1, 'toggle']);
$switch2->press->connect([$light2, 'toggle']);
$switchD->press->connect([$light1, 'toggle']);
$switchD->press->connect([$light2, 'toggle']);

$light1->info();
$light2->info();

$switch1->press();
$switch2->press();
$switch1->press();
$switchD->press();

$light1->info();
$light2->info();
