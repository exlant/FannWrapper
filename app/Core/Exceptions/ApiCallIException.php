<?php
declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\IException;
use App\Core\Abstracts\AException;

/**
 * Class ApiCallIException
 *
 * @package App\Core\Exceptions
 */
class ApiCallIException extends AException implements IException
{
    /**
     * @var
     */
    private $statusCode;
    private $content;

    public function __construct($statusCode, $content)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;

        $message = $statusCode . ': ' . (\is_array($content) ? json_encode($content) : $content);
        parent::__construct($message, $statusCode);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getContent()
    {
        return $this->content;
    }
}
