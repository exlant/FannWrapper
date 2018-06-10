<?php
declare(strict_types=1);

namespace App\Bundles\NeuralNetwork;

use App\Bundles\NeuralNetwork\Core\NNCommon;
use App\Bundles\NeuralNetwork\Core\FannCommand;
use App\Bundles\NeuralNetwork\Core\Settings;
use App\Core\Interfaces\IErrorHandler;
use App\Bundles\NeuralNetwork\Interfaces\ITrainAble;

/**
 * Class NeuralNetwork
 *
 * @package
 */
class NeuralNetwork extends NNCommon
{
    /**
     * @var ITrainAble
     */
    private $trainer;

    /**
     * NeuralNetwork constructor.
     *
     * @param Settings $settings
     * @param FannCommand $command
     * @param IErrorHandler $errorHandler
     * @param ITrainAble $train
     */
    public function __construct(Settings $settings, FannCommand $command, IErrorHandler $errorHandler, ITrainAble $train)
    {
        parent::__construct($settings, $command, $errorHandler);
        $this->trainer = $train;
    }

    public function simpleTrain()
    {
        $isTrain = $this->trainer->train();
        if (true === $isTrain) {
            $this->resourceNN = $this->trainer->getResourceNN();
        }
    }

    /**
     * @param array $input
     *
     * @return array
     */
    public function getOut(array $input): array
    {
        $out = $this->command->fannRun($this->getResourceNN(), $input);

        return $out;
    }

    private $nn;

    private function trainNN(bool $resume, int $trainingGames)
    {
        $numGames = 0;
        //loads weights if resuming training
        //else init with random weights
        if ($resume) {
            $numGames = $this->nn->loadWeights();
        } else {
            $this->nn->initWeights();
        }

        //run through x training games
        //updating weights after each games
        $gstates;
        $reward = [];//new double[outputNeurons];

        //time training time
        $starttime = microtime(true);

        for ($i = 0; $i < $trainingGames; $i++) {
            $gameStates = [];//new ArrayList<Double[]>();
            //connect, play with training mode, and disconnect
            /*socketConnect("localhost", 17033);
            if(!play(true)){break;}
            closeConnection();*/

            //unpack game states from arraylist into double[][]
            $gstates = unpackGS();
            //set reward for win/loss to 1/-1
            if (gs . equals("win")) {
                $reward[0] = 1;
            } elseif (gs . equals("lose")) {
                $reward[0] = -1;
            }

            echo(gs + "   :::   ");

            //train on game sequence
            $this->nn->train($gstates, $reward);
        }

        //end timer
        $endtime = microtime(true);
        echo("traing time for " . $i . " games: " . $endtime - $starttime);

        //save weights
        $this->nn->saveWeights($i + $numGames);
    }


}