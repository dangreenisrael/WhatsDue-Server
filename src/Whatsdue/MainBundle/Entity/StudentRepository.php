<?php
// src/AppBundle/Entity/ProductRepository.php
namespace Whatsdue\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\NoResultException;
use Moment\Moment;

class StudentRepository extends EntityRepository
{

    public function findTeacherStudents($teacherId)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT s, c
                FROM WhatsdueMainBundle:Student s
                JOIN s.courses c
                WHERE c.userId = ?1
                ")
            ->setParameter(1, $teacherId);
        try {
            return $query->execute();
        } catch (NoResultException $e) {
            return null;
        }
    }

}