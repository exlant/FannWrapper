<?php
declare(strict_types=1);

namespace App\Core\Interfaces;

/**
 * Interfase IOAuth2
 *
 * @package App\Core\Interfaces
 */
interface IOAuth2
{
    /**
     * @param $tokenParam
     * @param null $scope
     *
     * @return mixed
     */
    public function verifyAccessToken($tokenParam, $scope = null);
}