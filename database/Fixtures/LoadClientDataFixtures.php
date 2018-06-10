<?php
declare(strict_types=1);

namespace Database\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GNS\OAuthBundle\Entity\Client;
use OAuth2\OAuth2;

class LoadClientDataFixture extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $client->setRandomId('2y2i4fpadfi844gggogsg8coo00408c80kwos0gck40cc8kc84');
        $client->setSecret('51c915aa0n8k8cg0sscgw8cskksk4skc88k84oscksgccckock');
        $client->setRedirectUris(['/']);
        $client->setAllowedGrantTypes(
            [
                OAuth2::GRANT_TYPE_IMPLICIT,
                OAuth2::GRANT_TYPE_USER_CREDENTIALS,
                OAuth2::GRANT_TYPE_AUTH_CODE,
                OAuth2::GRANT_TYPE_REFRESH_TOKEN,
                OAuth2::GRANT_TYPE_EXTENSIONS,
            ]
        );
        $manager->persist($client);
        $manager->flush();
        $manager->getConnection()->exec('UPDATE oauth2_client SET id = 1;');
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int
    {
        return 1;
    }
}