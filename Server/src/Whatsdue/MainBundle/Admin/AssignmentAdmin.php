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
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;



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

    public function getDescription($courseID = null){
        $em = $this->getDoctrine();
        return $em->getRepository('WhatsdueMainBundle:Assignments')->findOneByCourseID($courseID)->getCourseDescription();
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        if ( $courseID = @$_GET['course']){
                $courseDescriptionType = "hidden";
                $courseDescriptionAtts = array('attr'=>array(
                    'value'=> $this->getDescription($_GET['course'])));

                $courseIDType = "hidden";
                $courseIDAtts = array('attr'=>array(
                    'value'=> $_GET['course']));
            }
            else{
                $courseDescriptionType = "textarea";
                $courseDescriptionAtts = array('attr'=>array(
                    'placeholder'   => "Description/Name of the course"
                ));

                $courseIDType = "text";
                $courseIDAtts = array('attr'=>array(
                    'label'   => "Course Code",
                    'placeholder'         => "Course Code"
                ));
            }


            $this->getCourses();
            $date   = new \DateTime();
            $date   = $date->format('m-d-Y');
            $formMapper

            ->add('courseID', $courseIDType, $courseIDAtts)
            ->add('courseDescription', $courseDescriptionType, $courseDescriptionAtts)
            ->add('assignmentName', 'text',array('attr'=>array(
                    'placeholder'=> "Assignment Name",
                    'label' => 'Assignment Name')))

            ->add('description', 'text', array('attr'=>array(
                    'placeholder'=> "Assignment Description",
                    'label' => 'Assignment Description'
                )))
            ->add('dueDate', 'text', array('attr'=>array(
                'class' =>"input-group form_datetime",
                'readonly' => ""
            )))

            ->add('adminID', 'hidden',(array('attr'=>array(
                'value'=> $this->getAdminID()
            ))))
        ;
    }

    /*
    ->add('dueDate', 'datetime', array('label' => 'Created At',
                'input' => 'string',
                'data' => $date." 12:00:00",
                'date_widget' => 'choice',
                'time_widget' => 'choice',
                'date_format' => 'MMM d y'))
    */
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
            ->addIdentifier('assignmentName')
            ->add('dueDate')
            ->add('courseID')
        ;
    }


}