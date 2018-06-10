<?php declare(strict_types=1);

namespace App\Bundles\OAuthBundle\Service;

use App\Bundles\AppBundle\Extension\OAuth2;
use App\Bundles\OAuthBundle\Entity\AccessToken;
use App\Bundles\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityService
{
    /** @var ContainerInterface */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return User|null
     */
    public function getCurrentUser()
    {
        // try get user from access token in token storage
        $accessToken = $this->container->get('security.token_storage')->getToken();

        if ($accessToken === null) {
            return null;
        }

        $currentUser = $accessToken->getUser();

        if ($currentUser instanceof User) {
            return $currentUser;
        }

        // try get user from access token in request (for not oauth routes)
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $accessToken = $this->getBearerToken($request);

        if ($accessToken === null) {
            return null;
        }

        /** @var AccessToken $tokenEntity */
        $tokenEntity = $this->container->get('doctrine')
            ->getRepository('CoreOAuthBundle:AccessToken')
            ->findOneBy(['token' => $accessToken]);

        if ($tokenEntity === null || $tokenEntity->hasExpired()) {
            return null;
        }

        $currentUser = $tokenEntity->getUser();

        return $currentUser;
    }

    private function getBearerToken(Request $request)
    {
        $tokens = [];

        $token = $this->getBearerTokenFromHeaders($request);
        if ($token !== null) {
            $tokens[] = $token;
        }

        $token = $this->getBearerTokenFromQuery($request);
        if ($token !== null) {
            $tokens[] = $token;
        }

        if (count($tokens) < 1) {
            // Don't throw exception here as we may want to allow non-authenticated
            // requests.
            return null;
        }

        return $tokens[0];
    }

    private function getBearerTokenFromQuery(Request $request)
    {
        if (!$token = $request->query->get(OAuth2::TOKEN_PARAM_NAME)) {
            return null;
        }

        return $token;
    }

    private function getBearerTokenFromHeaders(Request $request)
    {
        $header = null;
        if ($request->headers->has('AUTHORIZATION')) {
            $header = $request->headers->get('AUTHORIZATION');
        }

        if (!$header) {
            return null;
        }

        if (!preg_match('/' . preg_quote(OAuth2::TOKEN_BEARER_HEADER_NAME, '/') . '\s(\S+)/', $header, $matches)) {
            return null;
        }

        $token = $matches[1];

        return $token;
    }
}