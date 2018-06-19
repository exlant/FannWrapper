<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use App\Core\Traits\TimestampableEntity;
use App\Core\Traits\UuidableEntity;

/**
 * Class BaseEntity
 *
 * @package App\Core
 */
abstract class BaseEntity
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use UuidableEntity;
    
    /**
     * BaseEntity constructor.
     */
    public function __construct()
    {
        $this->uuid = generate_uuid();
    }
}