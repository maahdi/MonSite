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

    public function postLogoutAction()
    {
        $role = $this->get('security.context')->getToken()->getUser()->getRoles();
        if ($role[0] == 'visiteur')
        {
            $this->deleteTestEnvironnement();
        }
        return $this->redirect($this->generateUrl('logout'),301);
    }

    public function espaceClientAction()
    {
    }

    private function deleteTestEnvironnement()
    {
        $db = $this->get('database_connection');
        $sql = array('drop table menuTest','drop table pageTest','drop table articleTest');
        foreach ($sql as $query)
        {
            $db->query($query);
        }
    }


}
