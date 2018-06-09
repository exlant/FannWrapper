<?php
declare(strict_types=1);

namespace App\NeuralNetwork\Trainer;

use App\NeuralNetwork\Core\TrainerCommon;

/**
 * Class TrainByFile
 *
 * @package
 */
class TrainByFile extends TrainerCommon
{
    /**
     * @return bool
     */
    public function train(): bool
    {
        $this->resource = $this->command->fannCreateStandart($this->settings);
        if (null === $this->resource) {
            return false;
        }
        $isTrain = $this->command
            ->fannSetActivationFunctionHidden($this->resource, FANN_SIGMOID_SYMMETRIC)
            ->fannSetActivationFunctionOutput($this->resource, FANN_SIGMOID_SYMMETRIC)
            ->fannTrainOnFile($this->resource, $this->settings);

        if (true === $isTrain) {
            \fann_save($this->resource, $this->settings->getPathNet());
        }

        return $isTrain;
    }
}