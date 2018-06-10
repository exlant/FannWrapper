<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class BadRequestHttpIException
 *
 * @package App\Core\Exceptions
 */
class BadRequestHttpIException extends AException implements IException
{
}
