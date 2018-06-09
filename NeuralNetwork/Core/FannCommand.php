<?php
declare(strict_types=1);

namespace NeuralNetwork\Core;

use NeuralNetwork\Interfaces\IErrorHandler;
use NeuralNetwork\Interfaces\ISettings;

/**
 * Class FannCommand
 *
 * @package NeuralNetwork\Core
 */
class FannCommand
{
    /**
     * @var IErrorHandler
     */
    protected $IErrorHandler;

    public function __construct(IErrorHandler $IErrorHandler)
    {
        $this->IErrorHandler = $IErrorHandler;
    }

    /**
     * @param $resource
     *
     * @return void
     */
    public function destroy($resource): void
    {
        \fann_destroy($resource);
    }

    /**
     * @param string $path
     *
     * @return resource|null
     */
    public function fannCreateFromFile(string $path)
    {
        if (!\is_file($path)) {
            $this->IErrorHandler->addError(
                [
                    'msg' => 'The file xor_float.net has not been created! Please run simple_train.php to generate it',
                    'in' => self::class . ':fannCreateFromFile',
                ]
            );

            return null;
        }

        $nn = \fann_create_from_file($path);
        if (!$nn) {
            $this->IErrorHandler->addError(
                [
                    'msg' => 'NN could not be created',
                    'in' => self::class . ':fannCreateFromFile',
                ]
            );

            return null;
        }

        return $nn;
    }

    /**
     * @param resource $resource
     * @param array $input
     *
     * @return array|null
     */
    public function fannRun($resource, array $input): ?array
    {
        return \fann_run($resource, $input);
    }

    /**
     * @param Settings|ISettings $settings
     *
     * @return resource
     */
    public function fannCreateStandart(ISettings $settings)
    {
        $resource = \fann_create_standard(
            $settings->numLayers,
            $settings->numInput,
            $settings->numNeuronsHidden,
            $settings->numOutput
        );

        return $resource;
    }

    /**
     * @param $resource
     * @param int $flag
     *
     * @return self
     */
    public function fannSetActivationFunctionOutput($resource, int $flag): self
    {
        \fann_set_activation_function_output($resource, $flag);

        return $this;
    }

    /**
     * @param $resource
     * @param int $flag
     *
     * @return FannCommand
     */
    public function fannSetActivationFunctionHidden($resource, int $flag): self
    {
        \fann_set_activation_function_hidden($resource, $flag);

        return $this;
    }

    /**
     * @param $resource
     * @param string $path
     *
     * @return bool
     */
    public function fannSave($resource, string $path): bool
    {
        return \fann_save($resource, $path);
    }

    /**
     * @param $resource
     * @param Settings|ISettings $settings
     *
     * @return bool
     */
    public function fannTrainOnFile($resource, ISettings $settings): bool
    {
        return \fann_train_on_file(
            $resource,
            $settings->getPathData(),
            $settings->maxEpochs,
            $settings->epochBetweenReports,
            $settings->desiredError
        );
    }
}