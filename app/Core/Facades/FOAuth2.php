<?php
declare(strict_types=1);

namespace App\Core\Facades;

use App\Core\Interfaces\IOAuth2;
use FOS\OAuthServerBundle\Storage\OAuthStorage;
use OAuth2\OAuth2AuthenticateException;

/**
 * @property OAuthStorage $storage
 */
class FOAuth2 extends \OAuth2\OAuth2 implements IOAuth2
{
    const ERROR_INVALID_TOKEN = 'invalid_token';
    const ERROR_EXPIRED_TOKEN = 'expired_token';

    /**
     * @inheritdoc
     */
    public function verifyAccessToken($tokenParam, $scope = null)
    {
        $tokenType = $this->getVariable(self::CONFIG_TOKEN_TYPE);
        $realm = $this->getVariable(self::CONFIG_WWW_REALM);

        if (!$tokenParam) { // Access token was not provided
            throw new OAuth2AuthenticateException(self::HTTP_BAD_REQUEST, $tokenType, $realm, self::ERROR_INVALID_REQUEST, 'The request is missing a required parameter, includes an unsupported parameter or parameter value, repeats the same parameter, uses more than one method for including an access token, or is otherwise malformed.', $scope);
        }

        // Get the stored token data (from the implementing subclass)
        $token = $this->storage->getAccessToken($tokenParam);
        if (!$token) {
            throw new OAuth2AuthenticateException(self::HTTP_UNAUTHORIZED, $tokenType, $realm, self::ERROR_INVALID_TOKEN, 'The access token provided is invalid.', $scope);
        }

        // Check token expiration (expires is a mandatory paramter)
        if ($token->hasExpired()) {
            throw new OAuth2AuthenticateException(self::HTTP_UNAUTHORIZED, $tokenType, $realm, self::ERROR_EXPIRED_TOKEN, 'The access token provided has expired.', $scope);
        }

        // Check scope, if provided
        // If token doesn't have a scope, it's null/empty, or it's insufficient, then throw an error
        if ($scope && (!$token->getScope() || !$this->checkScope($scope, $token->getScope()))) {
            throw new OAuth2AuthenticateException(self::HTTP_FORBIDDEN, $tokenType, $realm, self::ERROR_INSUFFICIENT_SCOPE, 'The request requires higher privileges than provided by the access token.', $scope);
        }

        return $token;
    }
}