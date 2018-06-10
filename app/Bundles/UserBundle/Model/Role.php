<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Model;

use App\Bundles\AppBundle\Model\BaseConstant;

class Role extends BaseConstant
{
    const ADMIN = 'ROLE_ADMIN';
    const BUYER = 'ROLE_BUYER';
    const SELLER = 'ROLE_SELLER';
    const BLOCKCHAIN = 'ROLE_BLOCKCHAIN';
}