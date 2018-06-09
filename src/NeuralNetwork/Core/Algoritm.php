<?php
declare(strict_types=1);

namespace App\NeuralNetwork\Core;

/**
 * Class Algoritm
 *
 * @package App\NeuralNetwork\Core
 */
class Algoritm
{
    private $inputNeurons;
    private $hiddenNeurons;
    private $outputNeurons;
    private $hiddenWeights;
    private $outputWeights;
    private $hiddenBiases;
    private $outputBiases;

    //learning parameters
    private $lambda = 0.8; // how much feedback each state gets from next
    private $eta = 0.001; //learning rate
    private $gamma = 0.09; //decay factor

    public function NeuralNet(int $inputN, int $hiddenN, int $outputN)
    {
        $this->inputNeurons = $inputN;
        $this->hiddenNeurons = $hiddenN;
        $this->outputNeurons = $outputN;

        $this->hiddenWeights = []; //new double[$this->$inputNeurons][$this->hiddenNeurons];
        $this->hiddenBiases = [];//new double[$this->hiddenNeurons];

        $this->outputWeights = []; //new double[$this->hiddenNeurons][$this->outputNeurons];
        $this->outputBiases = []; //new double[$this->outputNeurons];

    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return float
     */
    public function randomFloat(int $min = 0, int $max = 1): float
    {
        return (float)($min + mt_rand() / mt_getrandmax() * ($max - $min));
    }

    //initialize weights to random values between -0.5 and 0.5
    public function initWeights()
    {
        for ($i = 0; $i < $this->inputNeurons; $i++) {
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                $this->hiddenWeights[$i][$j] = -0.5 + (0.5 - (-0.5)) * $this->randomFloat();
            }
        }

        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            for ($j = 0; $j < $this->outputNeurons; $j++) {
                $this->outputWeights[$i][$j] = -0.5 + (0.5 - (-0.5)) * $this->randomFloat();
            }
        }

        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            $this->hiddenBiases[$i] = -0.5 + (0.5 - (-0.5)) * $this->randomFloat();
        }

        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $this->outputBiases[$i] = -0.5 + (0.5 - (-0.5)) * $this->randomFloat();
        }
    }

    //feed input forward through network
    public function feedForward(array $input)
    {
        $output = []; //new double[$this->outputNeurons];
        $hidden = []; //new double[$this->hiddenNeurons];

        for ($i = 0; $i < $this->hiddenNeurons; $i++) {
            $sum = 1 * $this->hiddenBiases[$i];
            for ($j = 0; $j < $this->inputNeurons; $j++) {
                $sum += $input[$j] * $this->hiddenWeights[$j][$i];
            }
            $hidden[$i] = $this->sigmoid($sum);
        }

        for ($i = 0; $i < $this->outputNeurons; $i++) {
            $sum = 1 * $this->outputBiases[$i];
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                $sum += $hidden[$j] * $this->outputWeights[$j][$i];
            }
            $output[$i] = $this->sigmoid($sum);
        }

        return $output;
    }

    //activation function
    private function sigmoid(float $sum)
    {
        return 1 / (1 + \exp(-$sum));
    }

    //derivative of activation function
    private function sigPrime($input)
    {
        return $input * (1 - $input);
    }

    //sets weights (used for loading existing weights)
    public function setWeights(
        array $hidden,
        array $output,
        array $hBiases,
        array $oBiases
    ) {
        $this->hiddenWeights = $hidden;
        $this->outputWeights = $output;
        $this->hiddenBiases = $hBiases;
        $this->outputBiases = $oBiases;
    }

    public function getHW()
    {
        return $this->hiddenWeights;
    }

    public function getOW()
    {
        return $this->outputWeights;
    }

    public function getHB()
    {
        return $this->hiddenBiases;
    }

    public function getOB()
    {
        return $this->outputBiases;
    }

    public function train(array $gameStates, array $reward)
    {
        $this->backprop($gameStates, $reward);
    }

    //propagate error backwards for a game using temporal difference learning
    private function backprop(array $gameStates, array $reward)
    {
        $numStates = \count($gameStates); // . length;
        $gsOutputs = []; //new double[numStates][$this->outputNeurons];
        $gsHiddenAct = []; //new double[numStates][$this->hiddenNeurons];

        //for each board state in game
        for ($i = 0; $i < $numStates; $i++) {
            $output = []; //new double[$this->outputNeurons];
            $hidden = []; //new double[$this->hiddenNeurons];

            //feed to $hidden layer
            for ($k = 0; $k < $this->hiddenNeurons; $k++) {

                $sum = 1 * $this->hiddenBiases[$k];
                for ($j = 0; $j < $this->inputNeurons; $j++) {
                    $sum += $gameStates[$i][$k] * $this->hiddenWeights[$j][$k];
                }
                $hidden[$k] = $this->sigmoid($sum);
            }
            //save $hidden acts
            $gsHiddenAct[$i] = $hidden;

            //feed to output layer
            for ($k = 0; $k < $this->outputNeurons; $k++) {
                $sum = 1 * $this->outputBiases[$k];
                for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                    $sum += $hidden[$j] * $this->outputWeights[$j][$k];
                }
                $output[$k] = $this->sigmoid($sum);
            }
            //save output acts
            $gsOutputs[$i] = $output;
        }

        $totalError = 0;

        //calc the error of the reward and output
        $dvalues = []; //[numStates][$this->outputNeurons];
        $error = []; //[numStates][$this->outputNeurons];
        for ($td = 0; $td < $this->outputNeurons; $td++) {
            $dvalues[$numStates - 1][$td] = $reward[$td];
            $error[$numStates - 1][$td] = $dvalues[$numStates - 1][$td] - $gsOutputs[$numStates - 1][$td];

            $totalError += $error[$numStates - 1][$td] * $error[$numStates - 1][$td];
        }


        //calc desired value for each state
        //D(t) = $this->lambda * D(t+1) + $this->eta * (1-$this->lambda) * (R(t) + $this->gamma * A(t+1) - A(t))
        //R(t) = $this->gamma * R(t+1)
        //E(t) = D(t) - A(t)
        for ($d = $numStates - 2; $d > 0; $d--) {
            for ($r = 0; $r < $this->outputNeurons; $r++) {
                $reward[$r] = $this->gamma * $reward[$r];
                $dvalues[$d][$r] = $this->lambda * $dvalues[$d + 1][$r] + $this->eta * ((1 - $this->lambda)
                        * ($reward[$r] + $this->gamma * $gsOutputs[$d + 1][$r] - $gsOutputs[$d][$r]));
                $error[$d][$r] = $dvalues[$d][$r] - $gsOutputs[$d][$r];

                $totalError += $error[$d][$r] * $error[$d][$r];
            }
        }

        //System.out.println("Error first move: " + 0.5 * (error[numStates-2][0] * error[$numStates-2][0]));
        echo("Error last move: " . 0.5 * $totalError . PHP_EOL);

        $owGrads = []; //[$this->hiddenNeurons][$this->outputNeurons];
        $hwGrads = []; //[$this->inputNeurons][$this->hiddenNeurons];
        $hbGrads = []; //[$this->hiddenNeurons];
        $obGrads = []; //[$this->outputNeurons];
        //calculate deltas at each time step
        for ($i = 0; $i < $numStates; $i++) {

            //calculate grads for weights from $hidden to output
            for ($j = 0; $j < $this->outputNeurons; $j++) {
                //calc grads $hidden bias
                $obGrads[$j] += $error[$i][$j] * $this->sigPrime($gsOutputs[$i][$j]);

                for ($k = 0; $k < $this->hiddenNeurons; $k++) {
                    //calc grad for $hidden to output weights
                    $owGrads[$k][$j] += $error[$i][$j] * $this->sigPrime($gsOutputs[$i][$j])
                        * $gsHiddenAct[$i][$k];
                }
            }

            //calculate deltas for weights from input to $hidden neurons
            for ($j = 0; $j < $this->hiddenNeurons; $j++) {
                $delta = 0;
                for ($g = 0; $g < $this->outputNeurons; $g++) {
                    $delta += $this->outputWeights[$j][$g] * $owGrads[$j][$g];
                }

                //calc deltas bias weights
                $hbGrads[$j] += $delta * $this->sigPrime($gsHiddenAct[$i][$j]);

                //calc delta for $hidden to input weights
                for ($k = 0; $k < $this->inputNeurons; $k++) {
                    $hwGrads[$k][$j] += $delta * $this->sigPrime($gsHiddenAct[$i][$j]) * $gameStates[$i][$k];
                }
            }
        }
        //calculate new weights for $hidden to output
        for ($j = 0; $j < $this->outputNeurons; $j++) {
            //calc new $hidden bias weights
            $this->outputBiases[$j] += ($this->eta / $numStates) * $obGrads[$j];

            for ($k = 0; $k < $this->hiddenNeurons; $k++) {
                //calc new $hidden to output weights
                $this->outputWeights[$k][$j] += ($this->eta / $numStates) * $owGrads[$k][$j];
            }
        }

        //calculate new weights for input to $hidden neurons
        for ($j = 0; $j < $this->hiddenNeurons; $j++) {
            //calc new bias weights
            $this->hiddenBiases[$j] += ($this->eta / $numStates) * $hbGrads[$j];

            //calc discount for input neurons
            for ($k = 0; $k < $this->inputNeurons; $k++) {
                $this->hiddenWeights[$k][$j] += ($this->eta / $numStates) * $hwGrads[$k][$j];
            }
        }
    }
}