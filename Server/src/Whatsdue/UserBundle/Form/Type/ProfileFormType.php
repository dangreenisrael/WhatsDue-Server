<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whatsdue\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class ProfileFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('current_password')

            ->add('username', "text", array(
                'label' => ' ',
                'translation_domain' => 'FOSUserBundle',
                'data' => '',
                'attr' => array(
                    'class'         => 'form-control',
                    'placeholder'   => 'Choose Username (Max 10 Characters)',
                    'maxlength'     => '10'
                )
            ))
            ->add('email', 'email', array(
                'label' => ' ',
                'translation_domain' => 'FOSUserBundle',
                'data' => '',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Your Email'
                )
            ))
        ;

    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'whatsdue_user_profile';
    }

}
