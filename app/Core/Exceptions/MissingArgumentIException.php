<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class MissingArgumentIException
 *
 * @package App\Core\Exceptions
 */
class MissingArgumentIException extends AException implements IException
{
   private $argumentName;

    public function __construct($argumentName, $message = '')
    {
        if (empty($message)) {
            $message = $argumentName;
        }

        parent::__construct($message);

        $this->argumentName = $argumentName;
    }

    public function getArgumentName()
    {
        return $this->argumentName;
    }
}
