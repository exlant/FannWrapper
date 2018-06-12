<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Traits\TimestampableEntity;
use App\Core\Traits\UuidableEntity;
use App\Bundles\UserBundle\Model\LegalStatus;
use App\Bundles\UserBundle\Model\Role;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("identificationNumber", groups={"Registration", "Profile"})
 */
class User extends BaseUser
{
    use TimestampableEntity;
    use UuidableEntity;

    public const SOURCE_REGISTRATION_BY_EMAIL = 'REG_EMAIL';
    public const SOURCE_CREATED_BY_ADMIN = 'CREATED_BY_ADMIN';
    public const SOURCE_INTERNAL = 'INTERNAL';

    /**
     * @ORM\Id
     * @Serializer\Groups({"user"})
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="last_name", type="string", nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="first_name", type="string", nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="company_name", type="string", nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="mobile_number", type="string", nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="source", type="string", nullable=true)
     */
    private $source;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups("user")
     * @ORM\Column(name="registered_at", type="datetime", nullable=true)
     */
    private $registeredAt;

    /**
     * @var string
     *
     * @Serializer\Groups({"user"})
     * @ORM\Column(name="legal_status", type="string", length=50, nullable=true)
     */
    private $legalStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="identification_number", type="string", length=12, nullable=true, unique=true)
     */
    private $identificationNumber;

    public function __construct()
    {
        parent::__construct();
        $this->uuid = generate_uuid();
        $this->source = self::SOURCE_INTERNAL;
        $this->enabled = true;
        $this->legalStatus = LegalStatus::INDIVIDUAL;
    }

    /**
     * @Serializer\Groups({"user"})
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("email")
     */
    public function getEmailVirtual()
    {
        return $this->email;
    }

    /**
     * @Serializer\Groups({"user"})
     * @Serializer\VirtualProperty()
     */
    public function getConfirmed()
    {
        return $this->hasConfirmedRole();
    }

    /**
     * @Serializer\Groups({"user"})
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("roles")
     */
    public function getRolesVirtual()
    {
        return array_diff($this->getRoles(), [self::ROLE_DEFAULT]);
    }

    /**
     * @Serializer\Groups({"user"})
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("enabled")
     */
    public function getEnabledVirtual()
    {
        return $this->enabled;
    }

    public function hasConfirmedRole()
    {
        $roles = [
            Role::ADMIN,
            Role::BUYER,
            Role::SELLER,
        ];

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return User
     */
    public function setLastName($lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return User
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set companyName.
     *
     * @param string|null $companyName
     *
     * @return User
     */
    public function setCompanyName($companyName = null)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName.
     *
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set phoneNumber.
     *
     * @param string|null $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber = null)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set source.
     *
     * @param string|null $source
     *
     * @return User
     */
    public function setSource($source = null)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source.
     *
     * @return string|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set registeredAt.
     *
     * @param \DateTime|null $registeredAt
     *
     * @return User
     */
    public function setRegisteredAt($registeredAt = null)
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * Get registeredAt.
     *
     * @return \DateTime|null
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return User
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set legalStatus.
     *
     * @param string|null $legalStatus
     *
     * @return User
     */
    public function setLegalStatus($legalStatus = null)
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    /**
     * Get legalStatus.
     *
     * @return string|null
     */
    public function getLegalStatus()
    {
        return $this->legalStatus;
    }

    /**
     * Set identificationNumber.
     *
     * @param string|null $identificationNumber
     *
     * @return User
     */
    public function setIdentificationNumber($identificationNumber = null)
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    /**
     * Get identificationNumber.
     *
     * @return string|null
     */
    public function getIdentificationNumber()
    {
        return $this->identificationNumber;
    }
}
