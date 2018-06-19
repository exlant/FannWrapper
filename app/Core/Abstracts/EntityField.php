<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use App\Core\Exceptions\RuntimeIException;

/**
 * Class EntityField
 *
 * @package App\Core\Abstracts
 */
class EntityField extends RequestField
{
    /**
     * @var mixed
     */
    private $entityClass;
    /**
     * @var mixed|string
     */
    private $keyField;
    
    /**
     * EntityField constructor.
     * @param $name
     * @param array $parameters
     * @throws RuntimeIException
     */
    public function __construct($name, array $parameters = [])
    {
        parent::__construct($name, $parameters);

        if (!isset($parameters['entityClass'])) {
            throw new RuntimeIException('Entity class must be defined');
        }

        $this->entityClass = $parameters['entityClass'];
        $this->keyField = isset($parameters['keyField']) ? $parameters['keyField'] : 'uuid';
    }
    
    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }
    
    /**
     * @return mixed|string
     */
    public function getKeyField()
    {
        return $this->keyField;
    }
}