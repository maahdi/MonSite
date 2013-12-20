<?php

namespace Yomaah\structureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yomaah\structureBundle\Entity\Article;
use Yomaah\structureBundle\Entity\Page;
use Yomaah\structureBundle\Entity\Png;

class MainController extends Controller
{
    public function indexAction()
    {
        /**
         * Enregistrement d'un utilisateur avec nouveau password
         *
         **/
        //$factory = $this->get('security.encoder_factory');
        //$user = new \Yomaah\connexionBundle\Entity\User();
        //$encoder = $factory->getEncoder($user);
        //$password = $encoder->encodePassword('martini',null);
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('accueil');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:index.html.twig',
            array('articles' => $articles));
    }

    public function cvAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('cv');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:cv.html.twig',array('articles' => $articles));
    }

    public function projetAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('projets');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:projet.html.twig',
            array('articles' => $articles));
    }

    public function codeSourceGitAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('code_source');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig',
            array('git' => true,'articles' => $articles));
    }

    public function codeSourceAction($path)
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('code_source');
        $codeSourceController =$this->get('codeSource');
        $codeSourceController->init($path);

        //tableau contenant le template approprié à l'indice 'template'
        //et soit les noms des fichiers et dossiers du répertoire
        //soit le contenu du fichier demandé
        //Mergé le tableau avec n'importe quel tableau qui doit être passer à la vue
        $variable = $codeSourceController->getVariable();
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig', 
            array_merge($variable,array('articles'=> $articles)));
    }

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
        }else if ($role[0] == "administrateur")
        {
            //$this->get('yomaah_requete_listener')->incrementCompteur();
        }
        $this->get('session')->remove('testToken');
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
