<?php

namespace DeathSatan\LoadfileConfig\Load;

use Matomo\Ini\IniReader;
use Matomo\Ini\IniWriter;

class IniLoader implements \DeathSatan\LoadfileConfig\Interfaces\LoadInterface
{

    public function load($file)
    {
        $reader = new IniReader();
        return $reader->readFile($file);
    }

    public function build(array $value)
    {
        $Iniwrite = new IniWriter();
        return $Iniwrite->writeToString($value);
    }
}