<?php

use App\NeuralNetwork\Core\Settings;
use App\NeuralNetwork\Trainer\TrainByFile;
use App\NeuralNetwork\Core\FannCommand;
use App\NeuralNetwork\Service\ErrorHandler;
use App\NeuralNetwork\NeuralNetwork;
use App\NeuralNetwork\Service\ErrorObserver;
use App\NeuralNetwork\Test\PathFinder;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Common/Procedure/FileSystem.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_PATH', dirname (__FILE__));
define('VAR_PATH', ROOT_PATH . '/' . 'var');
define('NURO_STORAGE', VAR_PATH . '/' . 'nuro');

$errorHandler = new ErrorHandler();
$errorHandler->attach(new ErrorObserver());

$settings = new Settings($errorHandler);
$settings->numInput = 2;
$settings->numOutput = 1;
$settings->numLayers = 3;
$settings->numNeuronsHidden = 3;
$settings->desiredError = 0.001;
$settings->maxEpochs = 500000;
$settings->epochBetweenReports = 1000;
$settings->setPathData(NURO_STORAGE . '/xor_float.data');
$settings->setPathNet(NURO_STORAGE . '/xor_float.net');

$settingsPathFinder = new Settings($errorHandler);
$settingsPathFinder->numInput = 25;
$settingsPathFinder->numOutput = 25;
$settingsPathFinder->numLayers = 3;
$settingsPathFinder->numNeuronsHidden = 70;
$settingsPathFinder->desiredError = 0.001;
$settingsPathFinder->maxEpochs = 500000;
$settingsPathFinder->epochBetweenReports = 1000;
$settingsPathFinder->setPathData(NURO_STORAGE . '/pathFinder.data');
$settingsPathFinder->setPathNet(NURO_STORAGE . '/pathFinder.net');

$command = new FannCommand($errorHandler);
$trainer = new TrainByFile($settingsPathFinder, $command, $errorHandler);
//$nn = new NeuralNetwork($settings, $command, $errorHandler, $trainer);

//$nn->simpleTrain();

$pathFinder = new PathFinder($settingsPathFinder, $command, $errorHandler);
$pathFinder->render();
//$out = $nn->getOut([1,1]);


/*$ann = fann_create_from_file($pathToXorNet);