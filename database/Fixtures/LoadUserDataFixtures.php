<?php
declare(strict_types=1);

namespace Database\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GNS\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class LoadUserDataFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('Николай');
        $user1->setLastName('Федорик');
        $user1->setAddress('Киев');
        $user1->setPhoneNumber('+39083234234');
        $user1->setUsername('kolu4ka');
        $user1->setEmail('email@gmail.com');
        $user1->setPlainPassword('qwerty');
        $user1->setIdentificationNumber('123');

        $this->container->get('gns_user.user_manager')->update($user1, new ParameterBag());

        $this->addReference('user1', $user1);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}