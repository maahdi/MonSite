<?php

namespace Yomaah\structureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Yomaah\structureBundle\Entity\Article;
use Yomaah\structureBundle\Entity\Page;
use Yomaah\structureBundle\Entity\Png;

class TestController extends Controller
{
    public function accueilAction()
    {
        $dispatcher = $this->get('bundleDispatcher');
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')
                ->findByPage(array('pageUrl' => 'accueil', 'token' => $dispatcher->getIdSite()));
        return $this->container->get('templating')->renderResponse('yomaahBundle:Main:projet.html.twig',
            array('articles' => $articles));
    }
}
