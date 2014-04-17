<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-17
 * Time: 9:52 PM
 */

namespace Whatsdue\MainBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('name');
    }

    public function getName()
    {
        return 'Whatsdue_user_registration';
    }
}