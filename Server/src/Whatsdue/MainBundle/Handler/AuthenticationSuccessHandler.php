<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 9/21/14
 * Time: 7:49
 */

namespace Whatsdue\MainBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;


class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router   = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($token->getUser()->getEmail()  == $token->getUser()->getFacebookId())
        {
            $uri = $this->router->generate('fos_user_profile_edit');

            return new RedirectResponse($uri);
        }
        else
        {
            $uri = $this->router->generate('fos_user_security_login');
            return new RedirectResponse($uri);
        }
    }
}

