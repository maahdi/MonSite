<?php
namespace EuroLiterie\structureBundle\Classes;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MobileDetect
{
    private $session;
    private $request;

    public function __construct( Session $session, Request $request)
    {
        
        $this->session = $session;
        $this->request = $request;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (preg_match('/Android/', $this->request->headers->get('User-Agent')))
        {
            $this->session->set('mobile',true);
        }else
        {
            $this->session->set('mobile', false);
        }
    }
    
}
