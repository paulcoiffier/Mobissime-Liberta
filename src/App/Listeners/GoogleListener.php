<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 17:57
 */

namespace App\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class GoogleListener implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event)
    {
        //return new RedirectResponse("http://localhost");
        $event->setResponse(new RedirectResponse("http://localhost"));
    }

    public static function getSubscribedEvents()
    {
        return array('response' => array('onResponse', -255));
    }
}
