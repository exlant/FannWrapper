<?php
declare(strict_types=1);

namespace App\Core\Facades;

use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;

/**
 * Naming strategy which uses an annotation to translate the property name.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class CustomNameAnnotationStrategy implements PropertyNamingStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function translateName(PropertyMetadata $property)
    {
        if (null !== $name = $property->serializedName) {
            return $name;
        }

        return $property->name;
    }
}