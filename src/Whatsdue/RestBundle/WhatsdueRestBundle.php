<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 9/21/14
 * Time: 9:19
 */

namespace Whatsdue\RestBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class WhatsdueRestBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSRestBundle';
    }
}