<?php

namespace Unit;

use PHPUnit\Framework\TestCase;

class SignalTest extends TestCase
{
    private \A\Event\Signal $signalString;

    protected function setUp(): void
    {
        $this->signalString = new \A\Event\Signal();
    }

    public function testConnectFunction()
    {
        $callback = 'strtoupper';

        $this->assertTrue($this->signalString->connect($callback), 'Should connect function');

        $this->assertTrue($this->signalString->disconnect($callback), 'Should disconnect function');
    }

    public function testConnectClosure()
    {
        $callback = fn(string $string) : string => strtoupper($string);

        $this->assertTrue($this->signalString->connect($callback), 'Should connect closure');

        $this->assertTrue($this->signalString->disconnect($callback), 'Should disconnect closure');
    }

    public function testConnectStaticFunction()
    {
        $callback = SignalAsset::class.'::static_strtoupper';

        $this->assertTrue($this->signalString->connect($callback), 'Should connect static function');

        $this->assertTrue($this->signalString->disconnect($callback), 'Should disconnect static function');
    }

    public function testConnectStaticMethod()
    {
        $callback = [SignalAsset::class, 'static_strtoupper'];

        $this->assertTrue($this->signalString->connect($callback), 'Should connect static method');

        $this->assertTrue($this->signalString->disconnect($callback), 'Should disconnect static method');
    }

    public function testConnectMethod()
    {
        $callback = [new SignalAsset(), 'method_strtoupper'];

        $this->assertTrue($this->signalString->connect($callback), 'Should connect method');

        $this->assertTrue($this->signalString->disconnect($callback), 'Should disconnect method');
    }

    public function testEmit()
    {
        $object = new SignalAsset();

        $callback = [$object, 'setValue'];

        $this->signalString->connect($callback);

        foreach (['a', 'b', 'c'] as $value)
        {
            ($this->signalString)($value);

            $this->assertEquals($value, $object->value, 'Should emit value');
        }

        $this->signalString->disconnect($callback);
    }

    public function testEmitMultiple()
    {
        $object1 = new SignalAsset();
        $object2 = new SignalAsset();
        $object3 = new SignalAsset();

        $callback1 = [$object1, 'setValue'];
        $callback2 = [$object2, 'setValue'];
        $callback3 = [$object3, 'setValue'];

        $this->signalString->connect($callback1);
        $this->signalString->connect($callback2);
        $this->signalString->connect($callback3);

        foreach (['a', 'b', 'c'] as $value)
        {
            ($this->signalString)($value);

            $this->assertEquals($value, $object1->value, 'Should emit value for object1');
            $this->assertEquals($value, $object2->value, 'Should emit value for object2');
            $this->assertEquals($value, $object3->value, 'Should emit value for object3');
        }

        $this->signalString->disconnect($callback1);
        $this->signalString->disconnect($callback2);
        $this->signalString->disconnect($callback3);
    }
}
