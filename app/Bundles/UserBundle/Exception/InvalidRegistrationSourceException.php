<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Exception;

use App\Core\Exceptions\InvalidArgumentIException;

/**
 * Class InvalidRegistrationSourceException
 *
 * @package App\Bundles\UserBundle\Exception
 */
class InvalidRegistrationSourceException extends InvalidArgumentIException
{
    /**
     * InvalidRegistrationSourceException constructor.
     * @param $source
     */
    public function __construct($source)
    {
        $message = 'Invalid registration source: ' . $source;
        parent::__construct($message);
    }
}
