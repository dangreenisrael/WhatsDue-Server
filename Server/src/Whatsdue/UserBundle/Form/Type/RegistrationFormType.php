<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/4/14
 * Time: 15:07
 */

namespace Whatsdue\UserBundle\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('institutionName');
        //$builder->add('institutionAbbreviation');

    }

    public function getName()
    {
        return 'whatsdue_user_registration';
    }
}