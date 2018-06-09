<?php
declare(strict_types=1);

namespace App\NeuralNetwork\Service;

use NeuralNetwork\Interfaces\IErrorHandler;
use SplSubject;

/**
 * Class ErrorListener
 *
 * @package App\NeuralNetwork\Service
 */
class ErrorObserver implements \SplObserver
{
    /**
     * @param SplSubject|IErrorHandler $subject
     */
    public function update(SplSubject $subject)
    {
        foreach ($subject->getErrors() as $error) {
            \var_dump($error);
        }
    }
}