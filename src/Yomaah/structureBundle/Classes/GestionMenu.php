<?php

namespace Yomaah\structureBundle\Classes;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Yomaah\connexionBundle\Entity\User;
/**
 * Classe pour remplir les menus
 * Utilisé par MenuTwigExtension
 *
 **/
class GestionMenu
{
    private $entityManager;
    private $secure;
    private $session;

    public function __construct(\Doctrine\ORM\EntityManager $em,SecurityContextInterface $secure, Session $session)
    {
        $this->entityManager = $em;
        $this->secure = $secure;
        $this->session = $session;
    }

    public function getAllMenu()
    {
if ($this->secure->getToken() != null)
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
                $mLeft = $this->getMenu('left','MenuTest', $role[0]);
                $mRight = array(false);
                $admin = false;
                if ($this->isGranted('ROLE_USER'))
                {
                    $this->setTestMenu($mLeft);
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
//}else
//{
//$mLeft = $this->getMenu('left','Menu');
  //              $mRight = $this->getMenu('right','Menu');
    //            $admin = false;
//}

        $connect = $this->isGranted('ROLE_USER');
        return array('menuleft' => $mLeft,'menuright' => $mRight,'admin' => $admin,'connect' => $connect);
}
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
    private function getMenu($position, $menu, $role = null)
    {
        if ($position == 'left')
        {
            $fn = 'getLeft'.$menu;
        }else if ($position == 'right')
        {
            $fn = 'getRight'.$menu;
        }
        if ($role == null)
        {
            return $this->entityManager->getRepository('yomaahBundle:'.$menu)->$fn();
        }else if ($role == 'visiteur')
        {
            return $this->entityManager->getRepository('yomaahBundle:'.$menu)->$fn($this->session->get('testToken'));
        }    
    }

}
