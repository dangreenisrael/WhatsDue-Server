<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-05-16
 * Time: 1:05 PM
 */

namespace Whatsdue\MainBundle\Classes;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Whatsdue\MainBundle\Entity\Courses;
use Whatsdue\MainBundle\Entity\Assignments;

class LifecycleActions {

    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function getContainer(){
        return $this->container;
    }

    public function getAdminID () {
        return $this->getContainer()->get('security.context')->getToken()->getUser();
    }

    public function prePersist(LifeCycleEventArgs $args){

        /** UserId is recorded for ALL entries **/
        $entity = $args->getEntity();
        $adminId = $this->getAdminID();
        $entity->setAdminId($adminId);

        if ($entity instanceof Assignments) {
            $entity->setCourseName($_SESSION['courseName']);
            $entity->setCourseId($_SESSION['courseId']);

        }
    }
}
