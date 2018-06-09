<?php
declare(strict_types=1);

namespace NeuralNetwork\Interfaces;

/**
 * Interface IErrorHandler
 *
 * @package NeuralNetwork\Interfaces
 */
interface IErrorHandler
{
    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @param array $error
     *
     * @return void
     */
    public function addError(array $error): void;
}