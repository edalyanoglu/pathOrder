<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ordering;
use AppBundle\Entity\OrderItem;
use AppBundle\Helper\Traits\RepositoryOrdeByTrait;
use AppBundle\Helper\Traits\RepositoryPaginationTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * OrderItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderItemRepository  extends EntityRepository
{
    use RepositoryPaginationTrait;
    use RepositoryOrdeByTrait;

    /**
     * @param array|null $orderBy
     * @param null $limit
     * @param int $offset
     * @return mixed
     */
    public function findOrderItems(array $orderBy = null, $limit = null, $offset = 0)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('oi')
            ->from('AppBundle:OrderItem', 'oi')
        ;
        $this->initOrderBy($query, $orderBy);
        $this->initPagination($query, $limit, $offset);
        return $query->getQuery()->getResult();

    }

    /**
     * @param $id
     * @return OrderItem
     * @throws NonUniqueResultException
     */
    public function findOrderItemById($id)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('oi')
            ->from('AppBundle:OrderItem', 'oi')
            ->where('oi.id=:id')
            ->setParameter('id',$id)
        ;
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $id
     * @return OrderItem[]
     * @throws NonUniqueResultException
     */
    public function orderItemByOrder(Ordering $ordering)
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('oi')
            ->from('AppBundle:OrderItem', 'oi')
            ->join('oi.order','o')
            ->where('o.id=:id')
            ->setParameter('id',$ordering->getId())
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countOrderItem(){
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(oi.id)')
            ->from('AppBundle:OrderItem', 'oi')
        ;

        return $query->getQuery()->getSingleScalarResult();
    }
}