<?php
// src/AppBundle/Entity/ProductRepository.php
namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Moment\Moment;

class StudentAssignmentRepository extends EntityRepository
{


    public function findPaginated($userId, $page, $perPage)
    {
        $twoDaysAgo = new Moment();
        $twoDaysAgo->subtractDays(2)->format('Y-m-d');
        $query = $this->getEntityManager()
            ->createQuery("SELECT a, s
                FROM WhatsdueMainBundle:Assignment a
                JOIN a.studentAssignments s
                WHERE s.student = ?1
                AND a.archived = FALSE
                AND a.dueDate >= ?2
                AND (s.completed = FALSE or s.completed IS NULL)
                ORDER BY a.dueDate
                ")
            ->setParameter(1, $userId)
            ->setParameter(2, $twoDaysAgo)
            ->setMaxResults($perPage)
            ->setFirstResult( $perPage*($page-1) );
        try {
            $results =  new Paginator($query, $fetchJoin = true);
            return array(
                'assignment'=>$results->getIterator()->getArrayCopy(),
                'meta'  => array(
                    "total_pages" => ceil(count($results)/$perPage)
                )
            );
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findCompleted($userId)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT a, s
                FROM WhatsdueMainBundle:Assignment a
                JOIN a.studentAssignments s
                WHERE s.student = ?1
                AND a.archived = FALSE
                AND s.completed = TRUE
                ORDER BY s.completedDate
                ")
            ->setParameter(1, $userId)
            ->setMaxResults(20);
        try {
            $results =  new Paginator($query, $fetchJoin = true);
            foreach ($results as $result){
                $result->completed = true;
            }
            return array(
                'assignment'=>$results->getIterator()->getArrayCopy()
            );
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}