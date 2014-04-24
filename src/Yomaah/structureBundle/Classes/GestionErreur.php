<?php
namespace Yomaah\structureBundle\Classes;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\SecurityContext;

class GestionErreur
{
    private $templating;
    private $dispatcher;

    public function __construct($templating, \Yomaah\structureBundle\Classes\BundleDispatcher $dispatcher)
    {
        $this->templating = $templating;
        $this->dispatcher = $dispatcher;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // nous récupérons l'objet exception depuis l'évènement reçu
        $exception = $event->getException();
        $response = new Response();
        if (preg_match('/NotFoundHttpException/',get_class($exception)) === 1)
        {
            if ($this->dispatcher->isClientSite())
            {
                $message = $this->templating->render($this->dispatcher->getControllerPath().'Error:error404.html.twig');
                
            }else
            {
                $message = $this->templating->render('yomaahBundle:Error:error404.html.twig');
            }

        }else if (preg_match('/AccessDeniedHttpException/', get_class($exception)) === 1)
        {
            if ($this->dispatcher->isClientSite())
            {
                $gestionMenu = $this->dispatcher->getSitePath().'\\'.$this->dispatcher->getControllers().'\\Classes\\GestionMenu';
                $param = $gestionMenu::getOnException();
                $message = $this->templating->render($this->dispatcher->getControllerPath().'Error:error403.html.twig', $param);
                
            }else
            {
                $message = $this->templating->render('yomaahBundle:Error:error403.html.twig');
            }

        }else
        {
            $message = $exception->getMessage();
        }
        $response->setContent($message);
        $response->setStatusCode(200);
        $event->setResponse($response);
        //$message = 'My Error says: ' . $exception->getMessage() . ' with code: ' . $exception->getCode();

        //// personnalise notre objet réponse pour afficher les détails de notre exception

        //// HttpExceptionInterface est un type d'exception spécial qui
        //// contient le code statut et les détails de l'entête
        //if ($exception instanceof HttpExceptionInterface) {
            //$response->setStatusCode($exception->getStatusCode());
            //$response->headers->replace($exception->getHeaders());
        //} else {
            //$response->setStatusCode(500);
        //}

        //// envoie notre objet réponse modifié à l'évènement
        //$event->setResponse($response);
    }
    
}
