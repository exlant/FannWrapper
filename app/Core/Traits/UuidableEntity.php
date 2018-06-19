<?php
declare(strict_types=1);

namespace App\Core\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

trait UuidableEntity
{
    /**
     * @var string
     * @Serializer\Groups({"base"})
     * @ORM\Column(type="string", length=36, nullable=false, unique=true)
     * @Gedmo\Versioned
     */
    protected $uuid;
    
    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    public function setUuid()
    {
        // UUID must be set automatically in entity constructor
    }
}