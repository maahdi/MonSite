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
        $mLeft = $this->getMenu('left');
        $mRight = $this->getMenu('right');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:index.html.twig',array('articles' => $articles,'menuleft' => $mLeft,'menuright' => $mRight));
    }

    public function cvAction()
    {
        $mLeft = $this->getMenu('left');
        $mRight = $this->getMenu('right');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:cv.html.twig',array('menuleft' => $mLeft,'menuright' => $mRight));
    }

    public function projetAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('projet');
        $mLeft = $this->getMenu('left');
        $mRight = $this->getMenu('right');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:projet.html.twig',array('articles' => $articles, 'menuleft' => $mLeft,'menuright' => $mRight));
    }

    public function codeSourceAction($path)
    {
        $codeSourceController =$this->get('codeSource');
        $codeSourceController->init($path);

        //tableau contenant le template approprié à l'indice 'template'
        //et soit les noms des fichiers et dossiers du répertoire
        //soit le contenu du fichier demandé
        //Mergé le tableau avec n'importe quel tableau qui doit être passer à la vue
        $variable = $codeSourceController->getVariable();
        $mLeft = $this->getMenu('left');
        $mRight = $this->getMenu('right');
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig',
            array_merge($variable,array('menuleft' => $mLeft,'menuright' => $mRight)));
    }

    public function espaceClientAction()
    {
    }

    private function getMenu($position)
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
