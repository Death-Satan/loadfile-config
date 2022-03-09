<?php

namespace DeathSatan\LoadfileConfig\Interfaces;

interface LoadInterface
{
    public function load($file);

    public function build(array $value);
}