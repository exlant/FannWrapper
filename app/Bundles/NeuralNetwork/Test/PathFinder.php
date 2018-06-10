<?php
declare(strict_types=1);

namespace App\NeuralNetwork\Test;

use App\NeuralNetwork\Core\NNCommon;

/**
 * Class PathFinder
 *
 * @package NeuralNetwork\Test
 */
class PathFinder extends NNCommon
{

    public function process()
    {
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0));
        $this->Pathfinder($this->getResourceNN(),
            array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0));
    }

    public function render()
    {
        echo '<html>
            <head>
            <style>
                .blue{color:blue;}
                .red{color:red;}
            </style>
            </head>
            <body>';

        $this->process();

        echo '</body>
        </html>';
    }

    /**
     * @param resource $ann
     * @param array $array
     *
     * @return void
     */
    public function Pathfinder($ann, array $array): void
    {
        $calc_out = $this->command->fannRun($ann, $array);
        echo "<h1 class='blue'>Testing Pathfinder:</h1>";
        // Display Input Map
        for ($i = 0; $i <= 24; $i++) {
            if (\abs(\round($array[$i]) == 1)) {
                echo "<span class='red'>" . \abs(\round($array[$i])) . "</span>";
            } else {
                echo \abs(\round($array[$i]));
            }
            if ($i > 0 && ($i % 5) - 4 == 0) {
                echo "<br>" . PHP_EOL;
            }
        }
        echo "<h1 class='blue'>Results:</h1>";
        // Display Output Map
        for ($i = 0; $i <= 24; $i++) {
            if (\abs(\round($calc_out[$i]) == 1)) {
                echo "<span class='red'>" . \abs(\round($calc_out[$i])) . "</span>";
            } else {
                echo \abs(\round($calc_out[$i]));
            }

            if ($i > 0 && ($i % 5) - 4 == 0) {
                echo "<br>" . PHP_EOL;
            }
        }
    }

}