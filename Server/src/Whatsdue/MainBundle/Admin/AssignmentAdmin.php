<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-16
 * Time: 3:20 PM
 */

namespace Whatsdue\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AssignmentAdmin extends Admin
{

    public function getDoctrine(){
        return $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

    }

    public function getAdminID () {
        return $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();

    }

    public function getCourses(){
        $em = $this->getDoctrine();
        $allRows = $em->getRepository('WhatsdueMainBundle:Assignments')->findAll();

        $course = array(""=>"");
        foreach ($allRows as $key => $value){
            $course[] = $value->getCourseID();
        }
        return array_unique($course);
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->getCourses();
        $date   = new \DateTime();
        $date   = $date->format('Y-m-d');
        $formMapper
            ->add('assignmentName', 'text', array('label' => 'Title'))
            ->add('courseID', 'choice', array(
                'choices'=>$this->getCourses(),
                'attr' => array(
                    'id'=>'combo-box'
                )))
            ->add('courseID')
            ->add('description')
            ->add('dueDate', 'datetime', array('label' => 'Created At',
                'input' => 'string',
                'data' => $date." 12:00:00",
                'date_widget' => 'choice',
                'time_widget' => 'choice',
                'date_format' => 'MMM d y'))

            ->add('adminID', 'hidden',(array('attr'=>array(
                'value'=> $this->getAdminID()
            ))))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('courseID')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('assignmentName')
            ->add('dueDate')
            ->add('courseID')
        ;
    }
}