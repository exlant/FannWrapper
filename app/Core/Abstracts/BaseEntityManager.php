<?php
declare(strict_types=1);

namespace App\Core\Abstracts;

use Database\SQL\MysqlPaginationWalker;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BaseEntityManager
 *
 * @package App\Core
 */
abstract class BaseEntityManager
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @var string|null
     */
    protected $entityClass = null;

    /**
     * BaseEntityManager constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->validator = $container->get('validator');
    }

    /**
     * @param $uuid
     *
     * @return null|object
     */
    public function findByUuid($uuid)
    {
        return $this->getRepository()->findOneBy(['uuid' => $uuid]);
    }

    /**
     * @param $id
     *
     * @return null|object
     */
    public function findById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     */
    public function findOneBy(array $criteria, ?array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param Pagination $pagination
     *
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByFilters(array $criteria, array $orderBy = null, Pagination $pagination)
    {
        $qb = $this->getRepository()->createQueryBuilder('entity');

        $filtersBag = new ParameterBag($criteria);
        $orderByBag = new ParameterBag(\is_array($orderBy) ? $orderBy : []);

        $this->processFilters($qb, $filtersBag);
        $this->processOrderBy($qb, $orderByBag);

        $qb->setMaxResults($pagination->getLimit())
            ->setFirstResult($pagination->getOffset());
        $result = $qb->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, MysqlPaginationWalker::class)
            ->setHint("mysqlWalker.sqlCalcFoundRows", true)
            ->getResult();

        $pagination->setTotal($this->getFoundRows());

        return $result;
    }

    /**
     * @param ParameterBag|null $parameters
     * @param array $validationGroups
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(ParameterBag $parameters = null, $validationGroups = [])
    {
        $entity = new $this->entityClass;

        $this->update($entity, $parameters, $validationGroups);

        return $entity;
    }

    /**
     * @param $entity
     * @param ParameterBag|null $parameters
     * @param array $validationGroups
     *
     * @return mixed
     * @throws \Exception
     */
    public function update($entity, ParameterBag $parameters = null, $validationGroups = [])
    {
        if (null !== $parameters) {
            $parameters = new ParameterBag();
        }

        $this->em->beginTransaction();

        try {
            $this->load($entity, $parameters);
            $this->validate($entity, $validationGroups);
            $this->save($entity);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

        return $entity;
    }

    public function remove($entity, $andFlush = true)
    {
        $this->em->beginTransaction();

        try {
            $this->em->remove($entity);
            if ($andFlush) {
                $this->em->flush();
            }
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

    protected function validate($entity, $validationGroups = [])
    {
        $violations = $this->validator->validate($entity, null, $validationGroups);

        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }

        return true;
    }

    protected function save($entity, $andFlush = true)
    {
        $this->em->persist($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository($this->entityClass);
    }

    protected function load($entity, ParameterBag $parameters)
    {
    }

    protected function processFilters(QueryBuilder $qb, ParameterBag $parameters)
    {
    }

    protected function processOrderBy(QueryBuilder $qb, ParameterBag $parameters)
    {
    }

    /**
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getFoundRows(): int
    {
        return (int)$this->em->getConnection()
            ->query('SELECT FOUND_ROWS()')
            ->fetchColumn(0);
    }
}