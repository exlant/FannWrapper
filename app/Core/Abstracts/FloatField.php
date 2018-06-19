<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

/**
 * Class FloatField
 *
 * @package App\Core\Abstracts
 */
class FloatField extends RequestField
{
    public function getDefaultTransformers(): array
    {
        return [];
    }
}