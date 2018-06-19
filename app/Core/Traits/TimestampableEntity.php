<?php
declare(strict_types=1);

namespace App\Core\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

trait TimestampableEntity
{
    /**
     * @var \DateTime
     * @Serializer\Groups({"base"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;
    
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;
    
    /**
     * Sets createdAt.
     *
     * @param  \DateTime|int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        if (!$createdAt instanceof \DateTime) {
            $createdAt = (new \DateTime())->setTimestamp((int)$createdAt);
        }
        
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Sets updatedAt.
     *
     * @param  \DateTime|int $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        if (!$updatedAt instanceof \DateTime) {
            $updatedAt = (new \DateTime())->setTimestamp((int)$updatedAt);
        }
        
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
    
    /**
     * Returns updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}