<?php

namespace Whatsdue\RestBundle\View;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;
use Doctrine\Common\Util\Debug;


class EmberHandler
{

    /**
     * Renders the view data with the given template.
     *
     * @return array
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request)
    {
        $content = $view->getData();
        $serializer = SerializerBuilder::create()->build();
        // Clean Objects (remove unneeded data)
        foreach ($content as $data){
            if (is_object($data)){
                $data->cleanObject();
            } elseif(is_array($data)){
                foreach ($data as $eachObject){
                    if (is_object($eachObject)){
                        $eachObject->cleanObject();
                    }
                }
            }
        }
        //Debug::dump($content);
        $jsonResponse = $serializer->serialize($content, 'json');
        return new Response($jsonResponse, $view->getStatusCode(), $view->getHeaders());
    }
}