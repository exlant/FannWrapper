<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use Doctrine\Common\Collections\ArrayCollection;
use GNS\AppBundle\Transformer\TransformerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraint;

/**
 * Class RequestField
 *
 * @package App\Core\Abstracts
 */
abstract class RequestField
{
    /**
     * @var
     */
    private $name;
    /**
     * @var bool
     */
    private $required;

    /** @var Constraint[] */
    private $constraints;

    /** @var  TransformerInterface[] */
    private $transformers;
    
    /**
     * RequestField constructor.
     * @param $name
     * @param array $parameters
     */
    public function __construct($name, array $parameters = [])
    {
        $parameters = new ParameterBag($parameters);

        $this->name = $name;
        $this->constraints = new ArrayCollection((array)$parameters->get('constraints', []));
        $this->transformers = new ArrayCollection(array_merge((array)$parameters->get('transformers', []), $this->getDefaultTransformers()));
        $this->required = $parameters->getBoolean('required');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     * @return $this
     */
    public function setRequired($required): self
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return ArrayCollection|Constraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @param Constraint $constraint
     * @return $this
     */
    public function addConstraint(Constraint $constraint): self
    {
        $this->constraints->add($constraint);
        return $this;
    }

    /**
     * @return ArrayCollection|TransformerInterface[]
     */
    public function getTransformers()
    {
        return $this->transformers;
    }

    /**
     * @param TransformerInterface $transformer
     * @return RequestField
     */
    public function addTransformer(TransformerInterface $transformer): self
    {
        $this->transformers->add($transformer);
        return $this;
    }
    
    /**
     * @return array
     */
    public function getDefaultTransformers(): array
    {
        return [];
    }
}