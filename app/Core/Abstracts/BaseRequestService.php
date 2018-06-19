<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Exceptions\MissingArgumentIException;
use App\Core\Exceptions\NotFoundIException;
use App\Core\Exceptions\RuntimeIException;
use App\Core\Exceptions\ValidationIException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BaseRequestService
 *
 * @package App\Core\Abstracts
 */
abstract class BaseRequestService
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var EntityManagerInterface */
    private $em;
    
    /**
     * BaseRequestService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->validator = $container->get('validator');
        $this->em = $container->get('doctrine')->getManager();
    }
    
    /**
     * @param ParameterBag $requestParameters
     * @param ParameterBag|null $parameters
     * @param array $fields
     * @return ParameterBag
     */
    public function handleRequest(ParameterBag $requestParameters, ParameterBag $parameters = null, array $fields)
    {
        if (null === $parameters) {
            $parameters = new ParameterBag();
        }

        foreach ($fields as $field) {

            if (!$field instanceof RequestField) {
                new RuntimeException('Invalid field type: ' . gettype($field));
            }

            $this->transferField($requestParameters, $parameters, $field);
        }

        return $parameters;
    }
    
    /**
     * @param ParameterBag $requestParameters
     * @param ParameterBag $parameters
     * @param RequestField $field
     * @throws RuntimeIException
     * @throws MissingArgumentIException
     */
    private function transferField(ParameterBag $requestParameters, ParameterBag $parameters, RequestField $field)
    {
        $name = $field->getName();

        if ($requestParameters->has($name)) {

            $requestValue = $requestParameters->get($name);

            if ($field instanceof TextField) {
                $value = $this->processTextField($field, $requestValue);
            } elseif ($field instanceof EntityField) {
                $value = $this->processEntityField($field, $requestValue);
            } elseif ($field instanceof FloatField) {
                $value = $this->processFloatField($field, $requestValue);
            } elseif ($field instanceof IntField) {
                $value = $this->processIntField($field, $requestValue);
            } elseif ($field instanceof BoolField) {
                $value = $this->processBoolField($field, $requestValue);
            } else {
                throw new RuntimeIException('Unknown field type: ' . \get_class($field));
            }

            $parameters->set($name, $value);
        } else {
            if ($field->isRequired()) {
                throw new MissingArgumentIException($name);
            }
        }
    }
    
    /**
     * @param TextField $field
     * @param $requestValue
     * @return mixed
     */
    private function processTextField(TextField $field, $requestValue)
    {
        $this->transformValue($requestValue, $field->getTransformers());
        $this->validateValue($requestValue, $field->getConstraints(), $field->getName());

        $value = $requestValue;

        return $value;
    }
    
    /**
     * @param FloatField $field
     * @param $requestValue
     * @return mixed
     */
    private function processFloatField(FloatField $field, $requestValue)
    {
        $this->transformValue($requestValue, $field->getTransformers());
        $this->validateValue($requestValue, $field->getConstraints(), $field->getName());

        $value = $requestValue;

        return $value;
    }
    
    /**
     * @param IntField $field
     * @param $requestValue
     * @return mixed
     */
    private function processIntField(IntField $field, $requestValue)
    {
        $this->transformValue($requestValue, $field->getTransformers());
        $this->validateValue($requestValue, $field->getConstraints(), $field->getName());

        $value = $requestValue;

        return $value;
    }
    
    /**
     * @param BoolField $field
     * @param $requestValue
     * @return mixed
     */
    private function processBoolField(BoolField $field, $requestValue)
    {
        $this->transformValue($requestValue, $field->getTransformers());
        $this->validateValue($requestValue, $field->getConstraints(), $field->getName());

        $value = $requestValue;

        return $value;
    }
    
    /**
     * @param EntityField $field
     * @param $requestValue
     * @return array|null|object
     */
    private function processEntityField(EntityField $field, $requestValue)
    {
        if (null === ($requestValue)) {
            $value = $requestValue;
        } elseif (\is_array($requestValue)) {
            $value = [];
            foreach (\array_unique($requestValue) as $singleValue) {
                $value[] = $this->findEntity($field, $singleValue);
            }
        } else {
            $value = $this->findEntity($field, $requestValue);
        }

        return $value;
    }
    
    /**
     * @param EntityField $field
     * @param $value
     * @return null|object
     */
    private function findEntity(EntityField $field, $value)
    {
        $repo = $this->em->getRepository($field->getEntityClass());
        $keyField = $field->getKeyField();
        $entity = $repo->findOneBy([$keyField => $value]);

        if (null === ($entity)) {
            throw new NotFoundIException('error.not_found.common', [
                'field' => $field->getName(),
                $keyField => $value
            ]);
        }

        return $entity;
    }
    
    /**
     * @param $value
     * @param ArrayCollection $transformers
     */
    private function transformValue(&$value, ArrayCollection $transformers)
    {
        foreach ($transformers as $transformer) {
            $value = $transformer->transform($value);
        }
    }
    
    /**
     * @param $value
     * @param ArrayCollection $constraints
     * @param $field
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     * @throws ValidationIException
     */
    private function validateValue($value, ArrayCollection $constraints, $field)
    {
        if (\count($constraints) === 0) {
            return;
        }

        $violations = $this->validator->validate(
            [$field => $value],
            new Collection([$field => $constraints->toArray()])
        );

        if (\count($violations) > 0) {
            throw new ValidationIException($violations);
        }
    }
}