<?php

namespace Yomaah\connexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class ConnexionController extends Controller
{
    public function loginAction()
    {
        $menu = $this->get('gestionMenu')->getAllMenu();

        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('YomaahconnexionBundle:Default:login.html.twig', array(
        // last username entered by the user
        'last_username' => $session->get(SecurityContext::LAST_USERNAME),
        'error'   => $error,
        'menuleft' => $menu['left'],
        'menuright' => $menu['right']
        ));
    }

    private function getMenu()
    {
        if ($position == 'left')
        {
            return $this->getDoctrine()->getRepository('yomaahBundle:Menu')->getLeftMenu();
        }else if ($position == 'right')
        {
            return $this->getDoctrine()->getRepository('yomaahBundle:Menu')->getRightMenu();
        }
    }
}
