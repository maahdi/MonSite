<?php

namespace Yomaah\structureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yomaah\structureBundle\Entity\Article;
use Yomaah\structureBundle\Entity\Page;
use Yomaah\structureBundle\Entity\Png;
use Yomaah\structureBundle\Classes\BundleDispatcher;

class MainController extends Controller
{
    public function indexAction()
    {
        //$this->retourMonSiteEnAdminDepuisSiteClient();
        //$this->delTmpSession();
        /**
         * Enregistrement d'un utilisateur avec nouveau password
         *
         **/
        //$factory = $this->get('security.encoder_factory');
        //$user = new \Yomaah\connexionBundle\Entity\User();
        //$encoder = $factory->getEncoder($user);
        //$password = $encoder->encodePassword('martini',null);
        //$articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('MonAccueil');
        $params = $this->getParams('yomaah_accueil');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:accueil.html.twig', $params);
    }

    public function getParams($page)
    {
        $dispatcher = $this->get('bundleDispatcher');
        $dispatcher->unsetSite();
        if ($this->get('session')->has('rescueSite'))
        {
            $this->get('session')->set('norescue', true);
        }
        if ($this->get('security.context')->getToken()!= null)
        {
            if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))
            {
                $dispatcher->setAdmin();
            }
        }
        $params['articles'] = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage(array('pageUrl' => $page, 
                                                                                                'idSite' => $dispatcher->getIdSite()));
        return $params;
    }

    public function getAdminParams($page, $em, $dispatcher)
    {
        $params['articles'] = $em->getRepository('yomaahBundle:Article')->findByPage(array('pageUrl' => $page, 
                                                                                            'idSite' => $dispatcher->getIdSite()));
        return $params;
        
    }

    public function cvAction()
    {
        $params = $this->getParams('yomaah_cv');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:cv.html.twig', $params);
    }

    public function projetAction()
    {
        $params = $this->getParams('yomaah_projet');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:projet.html.twig', $params);
    }

    public function codeSourceGitAction()
    {
        $params = $this->getParams('yomaah_code_source');
        $params['git'] = true;
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig', $params);
    }

    public function codeSourceAction($path)
    {
        $params = $this->getParams('yomaah_code_source');
        $codeSourceController =$this->get('codeSource');
        $codeSourceController->init($path);
        $params = array_merge($codeSourceController->getVariable(), $params);

        //tableau contenant le template approprié à l'indice 'template'
        //et soit les noms des fichiers et dossiers du répertoire
        //soit le contenu du fichier demandé
        //Mergé le tableau avec n'importe quel tableau qui doit être passer à la vue
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig', $params);
    }

    //public function retourMonSiteEnAdminDepuisSiteClient()
    //{
        //$dispatch = $this->get('bundleDispatcher');
        //if(($this->get('session')->has('idSite') && $dispatch->isClientSite() === false))
        //{
            //$this->get('session')->remove('idSite');
        //}
    //}

    /**
     * Path du lien déconnection envoie ici
     * Supprime les enregistrements effectués dans les tables de test
     * et renvoie vers la route logout de connexionBundle
     *
     **/
    public function postLogoutAction()
    {
        $role = $this->get('security.context')->getToken()->getUser()->getRoles();
        if ($role[0] == 'visiteur')
        {
            $this->deleteTestEnvironnement();
            $this->get('session')->remove('testToken');
        }
        if ($this->get('session')->has('site') && $this->get('session')->has('idSite'))
        {
            $this->get('session')->remove('site');
            $this->get('session')->remove('idSite');
            $this->get('session')->remove('rescueSite');
            $this->get('session')->remove('rescueIdSite');
        }
        return $this->redirect($this->generateUrl('logout'),301);
    }

    private function deleteTestEnvironnement()
    {
        $db = $this->get('database_connection');
        $token = $this->get('session')->get('testToken');
        $sql = array('delete from menuTest where token = ?','delete from articleTest where token = ?','delete from pageTest where token = ?');
        foreach ($sql as $query)
        {
            $db->executeQuery($query, array($token));
        }
    }


}
