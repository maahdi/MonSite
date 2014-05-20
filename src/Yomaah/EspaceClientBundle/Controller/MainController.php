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
            $dispatcher->unsetSite();
            if ($secure->isGranted('ROLE_SUPER_ADMIN'))
            {
                return $this->accueilAdminAction();

            }else if ($secure->isGranted('ROLE_ADMIN'))
            {
                $user = $secure->getToken()->getUser();
                $param['articles'] = $this->getDoctrine()->getRepository('yomaahBundle:Article')
                        ->findByPage(array('pageUrl' => 'espace_client_accueil', 'idSite' => $dispatcher->getIdSite()));
                $param['sites'] = $user->getSites();       
                $param['userName'] = $user->getUserFirstName().' '.$user->getUserLastName();
                return $this->render('YomaahEspaceClientBundle:Main:accueil.html.twig', $param);
            }
        }
    }

    public function accueilAdminAction()
    {
        $secure = $this->get('security.context');
        $dispatcher = $this->get('bundleDispatcher');
        $request = $this->get('request');
        if ($secure->getToken() != null)
        {
            if ($secure->isGranted('ROLE_SUPER_ADMIN'))
            {
                $dispatcher->setAdmin();
                $param['users'] = $this->getDoctrine()->getRepository('YomaahconnexionBundle:User')->findByGroup(array('idGroup' => 400));
                //$param['baseUrl'] = 'http://'.$request->getHttpHost().$request->getBaseUrl().'/';
                return $this->render('YomaahEspaceClientBundle:Main:accueilAdmin.html.twig', $param);
            }
        }
    }

    public function getSiteAction($site)
    {
        $secure = $this->get('security.context');
        $dispatcher = $this->get('bundleDispatcher');
        $tmp = explode('_', $site);
        if ($secure->getToken() != null && $secure->isGranted('ROLE_SUPER_ADMIN'))
        {
            $this->get('session')->set('rescueSite', $tmp[0]);
            $dispatcher->setSite($tmp[0]);
            $tmpsite = $this->getDoctrine()->getRepository('yomaahBundle:Site')->findOneBy(array('nomSite' => $tmp[0]));
            $dispatcher->setIdSite($tmpsite->getIdSite());
            $this->get('session')->set('rescueIdSite', $tmpsite->getIdSite());

        }else if ($secure->getToken() != null && $secure->isGranted('ROLE_ADMIN'))
        {
            if ($secure->isGranted('ROLE_ADMIN'))
            {
                $user = $secure->getToken()->getUser();
                foreach($user->getSites() as $s)
                {
                    if ($s->getNomSite() == $tmp[0])
                    {
                        $this->get('session')->set('rescueSite', $tmp[0]);
                        $this->get('session')->set('rescueIdSite', $s->getIdSite());
                        $dispatcher->setSite($tmp[0]);
                        $dispatcher->setIdSite($s->getIdSite());
                    }
                }
            }
        }
        return $this->redirect($this->generateUrl($site), 301);
    }
}
