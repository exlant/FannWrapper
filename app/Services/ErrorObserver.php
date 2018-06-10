<?php
declare(strict_types=1);

namespace App\Service;

use App\Interfaces\IErrorHandler;
use SplSubject;

/**
 * Class ErrorListener
 *
 * @package NeuralNetwork\Service
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