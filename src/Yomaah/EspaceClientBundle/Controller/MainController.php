<?php

namespace Yomaah\EspaceClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function accueilAction()
    {
        $secure = $this->get('security.context');
        $dispatcher = $this->get('bundleDispatcher');
        if ($secure->getToken() !== null)
        {
            $user = $secure->getToken()->getUser();
            $dispatcher->unsetSite();
            if ($secure->isGranted('ROLE_ADMIN'))
            {
                $param['articles'] = $this->getDoctrine()->getRepository('yomaahBundle:Article')
                        ->findByPage(array('pageUrl' => 'espace_client_accueil', 'idSite' => $dispatcher->getIdSite()));
                $param['sites'] = $user->getSites();       
                $param['userName'] = $user->getUserFirstName().' '.$user->getUserLastName();
                return $this->render('YomaahEspaceClientBundle:Main:accueil.html.twig', $param);
            }
        }
    }

    public function getSiteAction($site)
    {
        $secure = $this->get('security.context');
        if ($secure->getToken() != null && $secure->isGranted('ROLE_ADMIN'))
        {
            $user = $secure->getToken()->getUser();
            $tmp = explode('_', $site);
            $dispatcher = $this->get('bundleDispatcher');
            foreach($user->getSites() as $s)
            {
                if ($s->getNomSite() == $tmp[0])
                {
                    $dispatcher->setSite($tmp[0]);
                    $dispatcher->setIdSite($s->getIdSite());
                }
            }
            return $this->redirect($this->generateUrl($site), 301);
        }
    }
}
