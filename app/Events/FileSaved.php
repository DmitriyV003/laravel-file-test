<?php

namespace App\Events;

class FileSaved
{
    public function __construct(
        public string $filename,
    ) {}
}
