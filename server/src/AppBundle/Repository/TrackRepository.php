<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * TrackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrackRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllTracks($currentPage = 1, $limit = 10, $sorted = [], $filtered = [])
    {
        $query = $this->createQueryBuilder('t');
        if (count($filtered)) {
            foreach ($filtered as $filter) {
                $query->andWhere('t.' . $filter['id'] . ' LIKE :value')
                    ->setParameter('value', "%{$filter['value']}%");
            }
        }
        if (count($sorted)) {
            foreach ($sorted as $sort) {
                $query->addOrderBy('t.' . $sort['id'], $sort['desc'] ? 'DESC' : '');
            }
        } else {
            $query->orderBy('t.artist');
        }

        return $this->paginate($query->getQuery(), $currentPage, $limit);
    }

    public function paginate($dql, $page = 1, $limit = 10)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * $page)// Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}