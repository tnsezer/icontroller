<?php

namespace App\Util;

interface WriterInterface
{
    public function write(array $header, array $data): string;
}