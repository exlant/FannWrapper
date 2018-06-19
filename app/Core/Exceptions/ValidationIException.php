<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationIException
 *
 * @package App\Core\Exceptions
 */
class ValidationIException extends AException implements IException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $list;

    public function __construct(ConstraintViolationListInterface $list)
    {
        parent::__construct(sprintf('Validation failed with %d error(s).', count($list)));

        $this->list = $list;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList()
    {
        return $this->list;
    }
}
