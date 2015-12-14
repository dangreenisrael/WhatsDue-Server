<?php
// src/AppBundle/Entity/ProductRepository.php
namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\NoResultException;
use Moment\Moment;

class StudentAssignmentRepository extends EntityRepository
{


    public function findPaginated($studentId, $page, $perPage)
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
            ->setParameter(1, $studentId)
            ->setParameter(2, $twoDaysAgo)
            ->setMaxResults($perPage)
            ->setFirstResult( $perPage*($page-1) );
        try {
            $results =  new Paginator($query, $fetchJoin = true);
            $assignments = $results->getIterator()->getArrayCopy();
            /** @var Assignment $assignment */
            foreach($assignments as $assignment){
                /** @var StudentAssignment $studentAssignment */
                $studentAssignment = $this->getEntityManager()
                    ->createQuery(
                        "SELECT s
                         FROM WhatsdueMainBundle:StudentAssignment s
                         WHERE s.student = ?1
                         AND s.assignment = ?2"
                    )
                    ->setParameter(1, $studentId)
                    ->setParameter(2, $assignment->getId())
                    ->getSingleResult();
                $assignment->setCompleted($studentAssignment->getCompleted());
                $assignment->setCompletedDate($studentAssignment->getCompletedDate());
                $assignment->setSeen($studentAssignment->getSeen());
                $assignment->setSeenDate($studentAssignment->getSeenDate());
            }
            return array(
                'assignment'=>$assignments,
                'meta'  => array(
                    "total_pages" => ceil(count($results)/$perPage),
                    "timestamp" => time()
                )
            );
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function findCompleted($userId)
    {

        $twoDaysAgo = new Moment();
        $twoDaysAgo->subtractDays(2)->format('Y-m-d');
        $query = $this->getEntityManager()
            ->createQuery("
                SELECT a, s
                FROM WhatsdueMainBundle:Assignment a
                JOIN a.studentAssignments s
                WHERE s.student = ?1
                AND a.archived = FALSE
                AND s.completed = TRUE
                AND a.dueDate > ?2
                ")
            ->setParameter(1, $userId)
            ->setParameter(2, $twoDaysAgo)
            ->setMaxResults(20);
        try {
            $results =  new Paginator($query, $fetchJoin = true);
            foreach ($results as $result){
                $result->completed = true;
            }
            return array(
                'assignment'=>$results->getIterator()->getArrayCopy(),
                'meta' => array(
                    'timestamp' => time()
                )
            );
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function findAssignmentTimestamp($userId, $timestamp)
    {
        $query = $this->getEntityManager()
            ->createQuery("
                SELECT a, s
                FROM WhatsdueMainBundle:Assignment a
                JOIN a.studentAssignments s
                WHERE s.student = ?1
                AND a.lastModified >= ?2
                ")
            ->setParameter(1, $userId)
            ->setParameter(2, $timestamp);
        try {
            $results =  new Paginator($query, $fetchJoin = true);
            return array(
                'records'=>array(
                    'assignment'=>$results->getIterator()->getArrayCopy()
                ),
                'meta' =>array(
                    "timestamp"=>time()
                )
            );
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function findStudentCourse($studentId, $courseId)
    {
//        $twoDaysAgo = new Moment();
//        $twoDaysAgo->subtractDays(2)->format('Y-m-d');
        $query = $this->getEntityManager()
            ->createQuery("SELECT s, a, c
                FROM WhatsdueMainBundle:StudentAssignment s
                JOIN s.assignment a
                JOIN a.course c
                WHERE s.student = ?1
                AND c.id = ?2
                ")
            ->setParameter(1, $studentId)
            ->setParameter(2, $courseId);
        try {
            return $query->execute();
        } catch (NoResultException $e) {
            return null;
        }
    }

}