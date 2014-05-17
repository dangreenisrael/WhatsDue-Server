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



class CoursesAdmin extends Admin
{



    public function getDoctrine(){
        return $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function getAdminID () {
        return $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser()->getUsernameCanonical();
    }



    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('courseName', 'text', array('label' => 'Course Name'))
            ->add('courseDescription','text', array( 'label' => 'Course Description'))
        ;

    }


    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('courseName')
            ->add('courseDescription')
            ->add('adminId')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('courseName')
            ->add('courseDescription')
            ->add('adminId')
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

            $filters['adminId']['value'] = $this->getAdminID();

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