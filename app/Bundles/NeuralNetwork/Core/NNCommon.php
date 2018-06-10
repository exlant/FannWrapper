<?php
declare(strict_types=1);

namespace App\Bundles\NeuralNetwork\Core;

use App\Interfaces\IErrorHandler;

/**
 * Class NNCommon
 *
 * @package NeuralNetwork\Core
 */
class NNCommon
{
    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @var FannCommand
     */
    protected $command;

    /**
     * @var resource
     */
    protected $resourceNN;

    /**
     * @var IErrorHandler
     */
    protected $errorHandler;

    /**
     * NeuralNetwork constructor.
     *
     * @param Settings $settings
     * @param FannCommand $command
     * @param IErrorHandler $errorHandler
     */
    public function __construct(Settings $settings, FannCommand $command, IErrorHandler $errorHandler)
    {
        $this->settings = $settings;
        $this->command = $command;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @return resource
     */
    public function getResourceNN()
    {
        if (null === $this->resourceNN) {
            $this->resourceNN = $this->command->fannCreateFromFile($this->settings->getPathNet());
        }

        return $this->resourceNN;
    }

    public function __destruct()
    {
        $this->command->destroy($this->resourceNN);
    }
}