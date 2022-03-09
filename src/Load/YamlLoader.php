<?php

namespace DeathSatan\LoadfileConfig\Load;

use Symfony\Component\Yaml\Yaml;

class YamlLoader implements \DeathSatan\LoadfileConfig\Interfaces\LoadInterface
{

    public function load($file)
    {
        return Yaml::parseFile($file,Yaml::PARSE_CONSTANT);
    }

    public function build(array $value)
    {
        return Yaml::dump($value,2,8);
    }
}