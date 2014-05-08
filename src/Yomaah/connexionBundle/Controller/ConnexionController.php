<?php

namespace Yomaah\connexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Yomaah\connexionBundle\Classes\NavBar;
use Yomaah\connexionBundle\Classes\ToolBar;
use Yomaah\connexionBundle\Classes\DisplayContent;
use Yomaah\connexionBundle\Classes\AdminLayout;
use Yomaah\connexionBundle\Classes\Element;
use Yomaah\connexionBundle\Classes\Onglet;

class ConnexionController extends Controller
{
    public function loginAction()
    {
        $dispatcher = $this->get('bundleDispatcher');
        if ($dispatcher->isClientSite())
        {
            $template = $dispatcher->getControllerPath().'Connexion:login.html.twig';
            $param['position'] = 'Login';
        }else
        {
            $template = 'YomaahconnexionBundle:Default:login.html.twig';
        }
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        if ($session->get(SecurityContext::LAST_USERNAME) == 'root' || $session->get(SecurityContext::LAST_USERNAME) == '')
        {
            $username = "test";
        }else
        {
            $username = $session->get(SecurityContext::LAST_USERNAME);
        }
        $param['last_username'] = $username;
        $param['error'] = $error;
        //return $this->render($template, array(
        //// last username entered by the user
        //'last_username' => $username,
        //'error'   => $error));
        return $this->render($template, $param);
    }

    public function testAction()
    {

        $layout = new AdminLayout(new NavBar(), new ToolBar(), new DisplayContent(new Element('article', null, 'displayContent'), 'accueil'));

        return new Response($layout->getHtml());
        
    }
}
