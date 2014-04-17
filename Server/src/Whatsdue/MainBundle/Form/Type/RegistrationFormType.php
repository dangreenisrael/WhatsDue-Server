<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 2014-04-17
 * Time: 9:52 PM
 */

namespace Whatsdue\MainBundle\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);


        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken(""); //Intention should be empty string, if you did not define it in parameters

        // add your custom field
    }

    public function getName()
    {
        return 'whatsdue_user_registration';
    }
}