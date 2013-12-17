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
        $user = $this->secure->getToken()->getUser();
        if ($user == "anon.")
        {
            $mLeft = $this->getMenu('left','Menu');
            $mRight = $this->getMenu('right','Menu');
            $admin = false;
            $connect = false;
            
        }else
        {
            $role = $user->getRoles();
            if ($role[0] == 'visiteur')
            {
                $mLeft = $this->getMenu('left','MenuTest');
                $mRight = array(false);
                $admin = false;
                if ($this->isGranted('ROLE_USER'))
                {
                    $this->setTestMenu($mLeft);
                    //$this->setTestMenu($mRight);
                    $admin = $this->isGranted('ROLE_USER');
                }   
            }else
            {
                $mLeft = $this->getMenu('left','Menu');
                $mRight = $this->getMenu('right','Menu');
                $admin = false;
                if ($this->isGranted('ROLE_SUPER_ADMIN'))
                {
                    $this->setAdminMenu($mLeft);
                    $admin = $this->isGranted('ROLE_SUPER_ADMIN');
                    $this->setAdminMenu($mRight);
                }   
            }
        }
        $connect = $this->isGranted('ROLE_USER');
        return array('menuleft' => $mLeft,'menuright' => $mRight,'admin' => $admin,'connect' => $connect);
    }

    private function setAdminMenu($menu)
    {
        foreach ($menu as $m)
        {
            $m->setPath('admin_'.$m->getPath());
        }
    }

    private function setTestMenu($menu)
    {
        foreach ($menu as $m)
        {
            $m->setPath('test_'.$m->getPath());
        }
        
    }

    public function isGranted($role)
    {
        if ($this->secure->isGranted($role))
        {
            return true;
        }else
        {
            return false;
        }
    }
    private function getMenu($position,$menu)
    {
        if ($position == 'left')
        {
            return $this->entityManager->getRepository('yomaahBundle:'.$menu)->getLeftMenu();
        }else if ($position == 'right')
        {
            return $this->entityManager->getRepository('yomaahBundle:'.$menu)->getRightMenu();
        }
    }
}
