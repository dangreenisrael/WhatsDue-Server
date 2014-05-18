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

    public function getAdminId () {
        return $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
    }


    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        if (@$_GET['course']){
            $_SESSION['courseId']   = @$_GET['course'];
            $_SESSION['courseName'] = @$_GET['courseName'];
        }
        $date   = new \DateTime();
        $date   = $date->format('m-d-Y');
        $formMapper
        ->add('assignmentName', 'text',array('attr'=>array(
                'placeholder'=> "Assignment Name",
                'label' => 'Assignment Name')))

        ->add('description', 'textarea', array('attr'=>array(
                'placeholder'=> "Assignment Description",
                'label' => 'Assignment Description'
            )))
        ->add('dueDate', 'text', array('attr'=>array(
            'class' =>"input-group form_datetime",
            'readonly' => ""
            )))
        ;
    }


    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('courseName')
            ->add('adminId')
            ->add('courseId')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('assignmentName')
            ->add('dueDate')
            ->add('courseName')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterParameters()
    {
        $parameters = array();

        // build the values array
        if ($this->hasRequest()) {
            $filters = $this->request->query->get('filter', array());

            /** Ensure only admins get in  **/
            $filters['adminId']['value'] = $this->getAdminId();

            /** Only Show courses, if one is selected **/
            if(@isset($_GET['course'])){
                $activeCourse = $_GET['course'];
                var_dump($activeCourse);
                $filters['courseId']['value'] = $activeCourse;
            }

            // if persisting filters, save filters to session, or pull them out of session if no new filters set
            if ($this->persistFilters) {
                if ($filters == array() && $this->request->query->get('filters') != 'reset') {
                    $filters = $this->request->getSession()->get($this->getCode().'.filter.parameters', array());
                } else {
                    $this->request->getSession()->set($this->getCode().'.filter.parameters', $filters);
                }
            }

            $parameters = array_merge(
                $this->getModelManager()->getDefaultSortValues($this->getClass()),
                $this->datagridValues,
                $filters
            );

            if (!$this->determinedPerPageValue($parameters['_per_page'])) {
                $parameters['_per_page'] = $this->maxPerPage;
            }

            // always force the parent value
            if ($this->isChild() && $this->getParentAssociationMapping()) {
                $name = str_replace('.', '__', $this->getParentAssociationMapping());
                $parameters[$name] = array('value' => $this->request->get($this->getParent()->getIdParameter()));
            }
        }

        return $parameters;
    }


}