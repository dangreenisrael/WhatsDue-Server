<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 2/20/15
 * Time: 23:29
 */

namespace Whatsdue\MainBundle\Classes;


use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
class EventListeners {
    public function lastRoute(GetResponseEvent $event)
    {
        // Do not save subrequests
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');
        if ($routeName[0] == '_') {
            return;
        }
        $routeData = ['name' => $routeName, 'params' => $routeParams];

        // Do not save same matched route twice
        $thisRoute = $session->get('this_route', []);
        if ($thisRoute == $routeData) {
            return;
        }
        $session->set('last_url', $session->get('this_url'));
        $session->set('this_url', $request->getRequestUri());
    }
}