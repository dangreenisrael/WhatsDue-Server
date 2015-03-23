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
        $builder->add('institutionName',
            'choice',
            array(
                'choices' => $this->container->get('helper')->getSchoolsList()
            )
        );
//        $builder->add('institutionName', 'choice', array(
//            'choices'   => array(
//                ''                                       => 'Choose a School (Type to Search)',
//                'IDC Herzliya'                           => 'IDC Herzliya',
//                'Front Range Community College'          => 'Front Range Community College',
//                'UMD (University of Maryland)'           => 'UMD (University of Maryland)',
//                'UNK (University of Nebraska Kearney)'   => 'UNK (University of Nebraska Kearney)',
//                'KPU (Kwantlen Polytechnic University)'  => 'KPU (Kwantlen Polytechnic University)',
//                'Ryerson University'                     => 'Ryerson University',
//                'UWO (University of Western Ontario)'    => 'UWO (University of Western Ontario)',
//                'UBC (University of British Columbia)'   => 'UBC (University of British Columbia)',
//                'RYNJ' => 'RYNJ'
//
//            ),
//            'multiple'  => false,
//        ));
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