<?php
namespace EuroLiterie\structureBundle\Classes;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MobileDetect
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (preg_match('/Android/', $request->headers->get('User-Agent')))
        {
            $request->getSession()->set('mobile',true);
        }else
        {
            $request->getSession()->set('mobile', false);
        }
    }
}
