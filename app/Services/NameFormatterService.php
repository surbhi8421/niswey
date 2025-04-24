<?php

namespace App\Services;

class NameFormatterService
{
    public function format(string $name): string
    {
        return ucwords(strtolower(trim($name)));
    }
}
