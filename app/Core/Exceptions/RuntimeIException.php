<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class RuntimeIException
 *
 * @package App\Core\Exceptions
 */
class RuntimeIException extends AException implements IException
{
}
