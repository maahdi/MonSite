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
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findAll();
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
