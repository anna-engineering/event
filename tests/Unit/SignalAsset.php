<?php

namespace Unit;

class SignalAsset
{
    public string $value = '';

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function method_strtoupper(string $string) : string
    {
        return strtoupper($string);
    }

    public static function static_strtoupper(string $string) : string
    {
        return strtoupper($string);
    }
}
