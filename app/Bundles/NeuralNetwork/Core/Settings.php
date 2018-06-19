<?php
declare(strict_types=1);

namespace App\Bundles\NeuralNetwork\Core;

use App\Core\Interfaces\IErrorHandler;
use App\Bundles\NeuralNetwork\Interfaces\ISettings;

/**
 * Class Settings
 *
 * @package NeuralNetwork\Core
 */
class Settings implements ISettings
{
    private $errorHandler;

    public $numInput;
    public $numOutput;
    public $numLayers;
    public $numNeuronsHidden;
    public $desiredError;
    public $maxEpochs;
    public $epochBetweenReports;
    /**
     * @var string
     */
    public $pathData;

    /**
     * @var string
     */
    public $pathNet;

    /**
     * Settings constructor.
     *
     * @param IErrorHandler $errorHandler
     */
    public function __construct(IErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $pathNet
     *
     * @return $this
     */
    public function setPathNet(string $pathNet): self
    {
        if (true === \is_dir($pathNet)) {
            $this->errorHandler->addError([
                'type' => 'fatal',
                'message' => 'PathNet is a directory: ' . $pathNet
            ]);
        }
        $this->pathNet = \mk_file_if_not_exist($pathNet);

        return $this;
    }

    /**
     * @return string
     */
    public function getPathNet(): string
    {
        return $this->pathNet;
    }

    /**
     * @return string|null
     */
    public function getPathData(): ?string
    {
        return $this->pathData;
    }

    /**
     * @param string $pathData
     *
     * @return Settings
     */
    public function setPathData(string $pathData): self
    {
        if (false === \is_file($pathData)) {
            $this->errorHandler->addError([
                'type' => 'fatal',
                'message' => 'File: ' . $pathData . ' doesn\'t exist!'
            ]);
        }
        $this->pathData = $pathData;

        return $this;
    }
}