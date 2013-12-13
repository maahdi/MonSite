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
        $menu = $this->getMenu();
        $admin = $this->get('gestionMenu')->isGranted();
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:index.html.twig',
            array('articles' => $articles,'menuleft' => $menu['left'],'menuright' => $menu['right'],'admin' => $admin));
    }

    public function cvAction()
    {
        $menu = $this->getMenu();
        $admin = $this->get('gestionMenu')->isGranted();
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:cv.html.twig',
            array('menuleft' => $menu['left'],'menuright' => $menu['right'],'admin' => $admin));
    }

    public function projetAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('projet');
        $menu = $this->getMenu();
        $admin = $this->get('gestionMenu')->isGranted();
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:projet.html.twig',
            array('articles' => $articles, 'menuleft' => $menu['left'],'menuright' => $menu['right'],'admin' => $admin));
    }

    public function codeSourceGitAction()
    {
        $menu = $this->getMenu();
        $admin = $this->get('gestionMenu')->isGranted();

        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig',
            array('git' => true, 'menuleft' => $menu['left'],'menuright' => $menu['right'],'admin' => $admin));
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

        $menu = $this->getMenu();
        $admin = $this->get('gestionMenu')->isGranted();

        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:codeSource.html.twig',
            array_merge($variable,array('menuleft' => $menu['left'],'menuright' => $menu['right'],'admin' => $admin)));
    }

    
    private function getMenu()
    {
        return $this->get('gestionMenu')->getAllMenu();
    }

    public function espaceClientAction()
    {
    }


}
