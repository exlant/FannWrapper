<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class DataConflictIException
 *
 * @package App\Core\Exceptions
 */
class DataConflictIException extends AException implements IException
{
}
