<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Exception;

use App\Bundles\AppBundle\Exception\Exception;

class InvalidRegistrationSourceException extends \Exception implements Exception
{
    public function __construct($source)
    {
        $message = 'Invalid registration source: ' . $source;
        parent::__construct($message);
    }
}
