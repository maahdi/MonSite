<?php

namespace EuroLiterie\structureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:index.html.twig');
    }

    public function accueilAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('accueil',1);
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig',
            array('position' => 'Accueil','articles' => $articles));
    }

    public function marquesAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('marques',1);
        $marques = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Marque')->findAll();
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:marques.html.twig',
            array('position' => 'Nos Marques', 'articles' => $articles, 'marques' => $marques));
    }

    public function magasinAction()
    {
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:magasin.html.twig',array('position' => 'Notre magasin'));
    }

    public function contactAction()
    {
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig', array('position' => 'Nous trouver'));
    }
    /**
     * Remplace fonction de login
     * de Yomaah\connexionBundle
     **/
    public function adminAction()
    {
        $this->get('session')->set('zoneAdmin', true);
        return $this->redirect($this->generateUrl('admin_literie_accueil'),301);
    }
    public function decoadminAction()
    {
        $this->get('session')->remove('zoneAdmin');
        return $this->redirect($this->generateUrl('admin_literie_accueil'),301);
    }
}
