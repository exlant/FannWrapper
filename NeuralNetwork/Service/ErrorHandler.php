<?php
declare(strict_types=1);

namespace NeuralNetwork\Service;

use NeuralNetwork\Interfaces\IErrorHandler;

/**
 * Class ErrorHandler
 *
 * @package
 */
class ErrorHandler implements IErrorHandler, \SplSubject
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var \SplObjectStorage
     */
    protected $observers;

    /**
     * ErrorHandler constructor.
     *
     * @param \SplObjectStorage $observerStorage
     */
    public function __construct(\SplObjectStorage $observerStorage = null)
    {
        if (null === $observerStorage) {
            $observerStorage = new \SplObjectStorage();
        }

        $this->observers = $observerStorage;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $error
     *
     * @return void
     */
    public function addError(array $error): void
    {
        $this->errors[] = $error;

        if ($error['type'] === 'fatal') {
            $this->notify();
            die();
        }
    }

    /**
     * @param \SplObserver $observer
     */
    public function attach(\SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    /**
     * @param \SplObserver $observer
     */
    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}