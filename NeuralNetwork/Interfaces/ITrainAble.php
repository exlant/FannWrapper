<?php
declare(strict_types=1);

namespace NeuralNetwork\Interfaces;

/**
 * Interfase ITrainAble
 *
 * @package
 */
interface ITrainAble
{
    /**
     * @return bool
     */
    public function train(): bool;

    /**
     * @return ISettings
     */
    public function getSettings(): ISettings;

    /**
     * @return resource
     */
    public function getResourceNN();
}