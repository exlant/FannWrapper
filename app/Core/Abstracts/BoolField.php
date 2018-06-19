<?php

namespace App\Core\Abstracts;

use GNS\AppBundle\Transformer\BoolTransformer;

class BoolField extends RequestField
{
    public function getDefaultTransformers(): array
    {
        return [new BoolTransformer()];
    }
}