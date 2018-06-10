<?php declare(strict_types=1);

namespace App\Bundles\UserBundle\Model;

use App\Bundles\AppBundle\Model\BaseConstant;

class LegalStatus extends BaseConstant
{
    const INDIVIDUAL = 'INDIVIDUAL';
    const ENTREPRENEUR = 'ENTREPRENEUR';
    const LEGAL_ENTITY = 'LEGAL_ENTITY';
}