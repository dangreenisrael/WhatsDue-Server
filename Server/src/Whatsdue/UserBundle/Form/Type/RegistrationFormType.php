<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/4/14
 * Time: 15:07
 */

namespace Whatsdue\UserBundle\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\DependencyInjection\ContainerInterface;


class RegistrationFormType extends AbstractType
{

    private $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('institutionName');
    }

    public function getName()
    {
        return 'whatsdue_user_registration';
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

}