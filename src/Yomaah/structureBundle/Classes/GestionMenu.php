<?php

namespace Yomaah\structureBundle\Classes;
use Symfony\Component\Security\Core\SecurityContextInterface;

class GestionMenu
{
    private $entityManager;
    private $secure;

    public function __construct(\Doctrine\ORM\EntityManager $em,SecurityContextInterface $secure)
    {
        $this->entityManager = $em;
        $this->secure = $secure;
    }

    public function getAllMenu()
    {
        $mLeft = $this->getMenu('left');
        $mRight = $this->getMenu('right');
        if ($this->isGranted())
        {
            $this->setAdminMenu($mLeft);
            $this->setAdminMenu($mRight);
        }   
        return array('left' => $mLeft,'right' => $mRight);
    }

    private function setAdminMenu($menu)
    {
        foreach ($menu as $m)
        {
            $m->setPath('admin_'.$m->getPath());
        }
    }

    public function isGranted()
    {
        if ($this->secure->isGranted('ROLE_ADMIN'))
        {
            return true;
        }else
        {
            return false;
        }
    }
    private function getMenu($position)
    {
        if ($position == 'left')
        {
            return $this->entityManager->getRepository('yomaahBundle:Menu')->getLeftMenu();
        }else if ($position == 'right')
        {
            return $this->entityManager->getRepository('yomaahBundle:Menu')->getRightMenu();
        }
    }
}
