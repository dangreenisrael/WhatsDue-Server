<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 9/21/14
 * Time: 10:19
 */

namespace Whatsdue\UserBundle\Form\Handler;


use FOS\UserBundle\Form\Handler\ProfileFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;

class ProfileFormHandler extends BaseHandler
{


    protected function onSuccess(UserInterface $user)
    {
        $this->userManager->updateUser($user);
        header("Location: /");
        die();
    }
}