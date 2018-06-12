<?php
declare(strict_types=1);

namespace App\Bundles\UserBundle\Service;

use Doctrine\ORM\QueryBuilder;
use FOS\UserBundle\Doctrine\UserManager as FOSUserManager;
use App\Bundles\AppBundle\Model\BaseEntityManager;
use App\Bundles\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserManager extends BaseEntityManager
{
    protected $entityClass = User::class;

    /** @var FOSUserManager $fosUserManager */
    private $fosUserManager;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->fosUserManager = $container->get('fos_user.user_manager');
    }

    /**
     * @param $token
     * @return User|null
     */
    public function findUserByConfirmationToken($token)
    {
        return $this->fosUserManager->findUserByConfirmationToken($token);
    }

    /**
     * @param $email
     * @return User|null
     */
    public function findUserByEmail($email)
    {
        return $this->fosUserManager->findUserByEmail($email);
    }

    /**
     * @param User $entity
     * @param ParameterBag $parameters
     */
    protected function load($entity, ParameterBag $parameters)
    {
        if ($parameters->has('email')) {
            $email = $parameters->get('email');
            $entity->setEmail($email);
            $entity->setUsername($email);
        }

        if ($parameters->has('password')) {
            $entity->setPlainPassword($parameters->get('password'));
        }

        if ($parameters->has('firstName')) {
            $entity->setFirstName($parameters->get('firstName'));
        }

        if ($parameters->has('lastName')) {
            $entity->setLastName($parameters->get('lastName'));
        }

        if ($parameters->has('companyName')) {
            $entity->setCompanyName($parameters->get('companyName'));
        }

        if ($parameters->has('phoneNumber')) {
            $entity->setPhoneNumber($parameters->get('phoneNumber'));
        }

        if ($parameters->has('confirmationToken')) {
            $entity->setConfirmationToken($parameters->get('confirmationToken'));
        }

        if ($parameters->has('registeredAt')) {
            $entity->setRegisteredAt($parameters->get('registeredAt'));
        }

        if ($parameters->has('roles')) {
            foreach ($parameters->get('roles') as $role) {
                $entity->addRole($role);
            }
        }

        if ($parameters->has('source')) {
            $entity->setSource($parameters->get('source'));
        }

        if ($parameters->has('address')) {
            $entity->setAddress($parameters->get('address'));
        }

        if ($parameters->has('enabled')) {
            $entity->setEnabled($parameters->getBoolean('enabled'));
        }

        if ($parameters->has('passwordRequestedAt')) {
            $entity->setPasswordRequestedAt($parameters->get('passwordRequestedAt'));
        }

        if ($parameters->has('legalStatus')) {
            $entity->setLegalStatus($parameters->get('legalStatus'));
        }

        if ($parameters->has('identificationNumber')) {
            $entity->setIdentificationNumber($parameters->get('identificationNumber'));
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ParameterBag $parameters
     *
     * @return void
     */
    protected function processFilters(QueryBuilder $qb, ParameterBag $parameters): void
    {
        if ($parameters->has('search')) {
            $qb->andWhere('entity.username LIKE :search')
                ->orWhere('entity.lastName LIKE :search')
                ->orWhere('entity.firstName LIKE :search')
                ->orWhere('entity.email LIKE :search')
                ->setParameter('search', '%' . $parameters->get('search') . '%')
            ;
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param ParameterBag $parameters
     *
     * @return void
     */
    protected function processOrderBy(QueryBuilder $qb, ParameterBag $parameters): void
    {
        if ($parameters->count() > 0) {
            foreach ($parameters as $fieldName => $orderType) {
                $qb->addOrderBy('entity.' . $fieldName, $orderType);
            }

            return;
        }

        $qb->addOrderBy('entity.id', 'DESC');
    }

    protected function save($entity, $andFlush = true)
    {
        $this->fosUserManager->updateUser($entity, $andFlush);
    }
}