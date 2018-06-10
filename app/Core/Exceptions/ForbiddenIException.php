<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class ForbiddenIException
 *
 * @package App\Core\Exceptions
 */
class ForbiddenIException extends AException implements IException
{
}
