<?php
namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\NoResultException;

class CourseRepository extends EntityRepository
{
    public function hasStudent($course, $student)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT c, s
                FROM WhatsdueMainBundle:Course c
                JOIN c.students s
                WHERE c.id = ?1
                AND s.id = ?2
                ")
            ->setParameter(1, $course->getId())
            ->setParameter(2, $student->getId());
        try {
            return $query->execute();
        } catch (NoResultException $e) {
            return null;
        }
    }
}