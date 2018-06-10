<?php
declare(strict_types=1);

namespace App\NeuralNetwork\Core;

use App\Core\Interfaces\IErrorHandler;
use App\NeuralNetwork\Interfaces\ISettings;
use App\NeuralNetwork\Interfaces\ITrainAble;

/**
 * Class TrainerCommon
 *
 * @package
 */
abstract class TrainerCommon implements ITrainAble
{
    /**
     * @var Settings|ISettings
     */
    protected $settings;

    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var IErrorHandler
     */
    protected $errorHandler;
    /**
     * @var FannCommand
     */
    public $command;

    public function __construct(ISettings $settings, FannCommand $command, IErrorHandler $errorHandler)
    {
        $this->settings = $settings;
        $this->command = $command;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @return Settings|ISettings
     */
    public function getSettings(): ISettings
    {
        return $this->settings;
    }

    /**
     * @return resource
     */
    public function getResourceNN()
    {
        return $this->resource;
    }


}