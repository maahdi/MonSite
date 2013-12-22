<?php

namespace EuroLiterie\structureBundle\Classes;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
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
        $user = $this->secure->getToken()->getUser();
        /**
         * ROLE_ADMIN A REMPLACER PAR ROLE_USER
         **/
        $admin = false;
        if ((!($user == "anon."))&& $this->secure->isGranted('ROLE_ADMIN'))
        {
            /**
             * Partie pour tester le site avec mon identifiant
             * !!!Attention!!! 
             * A enlever
             * en prod mettre : 
             *     $menus = $this->getMenu('left','Menu');
             *     $admin = false;
             */
            if ($this->secure->isGranted('ROLE_SUPER_ADMIN'))
            {
                $menus = $this->getMenu('left','Menu');
                if (($this->session->get('zoneAdmin') != null) && $this->session->get('zoneAdmin'))
                {
                    $this->setAdminMenu($menus);
                    $this->session->set('idSite', 1);
                    $admin = true;
                }

            }else
            {
                $sitesAvailables = $user->getSites();
                $auth = false;
                foreach ($sitesAvailables as $site)
                {
                    if ($site->getNomSite() == 'literie')
                    {
                        $this->session->set('idSite', 1);
                        $auth = true;
                    }
                }
                $menus = null;
                if ($auth)
                {
                  $menus = $this->getMenu('left','Menu');
                }
                $admin = false;
                /**
                * Pour Test accès zone admin via session
                * La aussi à enlever
                **/
                if (($this->session->get('zoneAdmin') != null) && $this->session->get('zoneAdmin'))
                {
                    $this->setAdminMenu($menus);
                    $admin = true;
                }
            }
       /**
         * Vrai zone admin 
         * A décommenter
         **/
        //}else ($this->secure->isGranted('ROLE_ADMIN'))
        //{
            //$menus = $this->getMenu('left','Menu');
            //$admin = false;
            //if ($this->isGranted('ROLE_SUPER_ADMIN'))
            //{
              //$this->setAdminMenu($mLeft);
              //$admin = $this->isGranted('ROLE_SUPER_ADMIN');
              //$this->setAdminMenu($mRight);
            //}   
        //}
            if ($menus == null)
            {
                return array('menus' => false);
            }else
            {
                return array('menus' => $menus,'literie_admin' => $admin);
            }
        }return array(false);
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
            $site = 1;
            return $this->entityManager->getRepository('yomaahBundle:'.$menu)->$fn($site);
        }else if ($role == 'visiteur')
        {
            return $this->entityManager->getRepository('yomaahBundle:'.$menu)->$fn($this->session->get('testToken'));
        }    
    }

}
