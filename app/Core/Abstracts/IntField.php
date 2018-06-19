<?php

namespace App\Core\Abstracts;

use App\Core;

class IntField extends RequestField
{
    public function getDefaultTransformers(): array
    {
        return [];
    }
}