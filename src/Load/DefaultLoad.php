<?php

namespace DeathSatan\LoadfileConfig\Load;

use DeathSatan\LoadfileConfig\Interfaces\LoadInterface;
use Symfony\Component\VarExporter\VarExporter;

class DefaultLoad implements LoadInterface
{
    public function load($file)
    {
        return require($file);
    }

    public function build(array $value)
    {
        return VarExporter::export($value);
    }
}