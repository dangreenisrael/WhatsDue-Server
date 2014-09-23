<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 9/21/14
 * Time: 9:19
 */

namespace Whatsdue\UserBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class WhatsdueUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}