<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class PaginationService
 *
 * @package GNS\AppBundle\Service
 */
class Pagination
{
    /**
     * @Serializer\Groups({"pagination"})
     * @var int
     */
    protected $limit = 10;

    /**
     * @Serializer\Groups({"pagination"})
     * @var int
     */
    protected $page = 1;

    /**
     * @Serializer\Groups({"pagination"})
     * @var int
     */
    protected $total = 0;

    /**
     * @param int $page
     * @param int $limit
     * @param int $total
     */
    public function __construct(?int $page, ?int $limit, ?int $total = null)
    {
        if (null !== $page) {
            $this->page = $page;
        }

        if (null !== $limit) {
            $this->limit = $limit;
        }

        if (null !== $total) {
            $this->total = $total;
        }
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return Pagination
     */
    public function setTotal(int $total): Pagination
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->getLimit() * ($this->getPage() - 1);
    }
}