<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class NotFoundIException
 *
 * @package App\Core\Exceptions
 */
class NotFoundIException extends AException implements IException
{
    /**
     * @var array
     */
    private $criteria;

    public function __construct($message = '', array $criteria = [])
    {
        parent::__construct($message);

        $this->criteria = $criteria;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
