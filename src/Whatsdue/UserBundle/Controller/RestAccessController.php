<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 9/21/14
 * Time: 9:24
 */

namespace Whatsdue\UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Controller\Annotations\View,
    Doctrine\Common\Util\Debug,
    Whatsdue\MainBundle\Entity\User,
    Symfony\Component\EventDispatcher\EventDispatcher,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
    Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RestAccessController extends FOSRestController
{

    private function getDatetime(){
        $date = new \DateTime();
        return $date->format('Y-m-d\TH:i:sP');
    }

    private function encodePassword($user, $plainPassword){

        /** @var  User $user*/
        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    /**
     * @return array
     * @View()
     */
    public function postUserAction(Request $request)
    {
        $newUser = json_decode($request->getContent())->user;
        $user = new User();
        $user->setEmail($newUser->email);
        $user->setEmailCanonical($newUser->email);
        $user->setPassword($this->encodePassword($user, $newUser->password));
        $user->setSignupDate($this->getDatetime());
        $user->setFirstName($newUser->first_name);
        $user->setLastName($newUser->last_name);
        $user->setSalutation($newUser->salutation);
        $user->setInstitutionName($newUser->institution_name);
        $user->setEnabled(true);

        //We set a random username that will be replaced after it is persisted
        $user->setUsername($this->container->get('helper')->createCourseCode());
        $user->setUsernameCanonical($this->container->get('helper')->createCourseCode());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @return array
     * @View()
     */
    public function postLoginAction(Request $request){
        $request = json_decode($request->getContent());
        return $this->get('helper')->loginUser($request->username, $request->password);
    }

    /**
     * @return array
     * @View()
     */
    public function getLogoutAction()
    {
        // Logging user out.
        $this->get('security.context')->setToken(null);

        // Invalidating the session.
        $this->get('request')->getSession()->invalidate();

        return array("logged out"=>true);
    }

    /**
     * @return array
     * @View()
     */
    public function getUsersAction(){
        $user = $this->getUser();
        return array("user" => $user);
    }

    /**
     * @return array
     * @View
     */
    public function getEmailValidAction(Request $request){
        $email = $request->query->get('email');
        return $this->get('email')->validate($email);
    }

    /**
     * @return array
     * @View
     */
    public function getEmailNewAction(Request $request){
        $email = strtolower($request->query->get('email'));
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('WhatsdueMainBundle:User')->findOneBy(array(
            "email"=>$email
        ));
        return (!$user);
    }


}