<?php

namespace EuroLiterie\structureBundle\Classes;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Classe pour remplir les menus
 * Utilisé par MenuTwigExtension
 *
 **/
class GestionMenu
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function getAllMenu()
    {
        $request = $this->container->get('request');
        if (!(preg_match('/ajax/',$request->getPathInfo())))
        {
            return $this->getMenu($request);
        }else
        {
            return array(false);
        }
    }

    public function getMenu($request)
    {
        $session = $request->getSession();
        $secure = $this->container->get('security.context');
        $user = $secure->getToken()->getUser();
        /**
         * L'utilisateur doit être connecter
         * soit un client soit moi
         **/
        $admin = false;
        if ((!($user == "anon."))&& $secure->isGranted('ROLE_ADMIN'))
        {
            /**
             * Partie pour tester le site avec mon identifiant
             * !!!Attention!!! 
             * A enlever
             * en prod mettre : 
             *     $menus = $this->getMenuFromRepo('left','Menu');
             *     $admin = false;
             */
            if ($secure->isGranted('ROLE_SUPER_ADMIN'))
            {
                $menus = $this->getMenuFromRepo('left','Menu');
                if (($session->get('zoneAdmin') != null) && $session->get('zoneAdmin'))
                {
                    $this->setAdminMenu($menus);
                    $session->set('idSite', 1);
                    $admin = true;
                }

            }else
            {
                $sitesAvailables = $user->getSites();
                $auth = false;
                /**
                 * vérifie que le site appartient bien à l'utilisateur qui le visite
                 */
                foreach ($sitesAvailables as $site)
                {
                    if ($site->getNomSite() == 'literie')
                    {
                        $session->set('idSite', 1);
                        $auth = true;
                    }
                }
                $menus = null;
                if ($auth)
                {
                  $menus = $this->getMenuFromRepo('left','Menu');
                }
                $admin = false;
                /**
                 * pour simuler connexion à la zone admin
                 */
                if (($session->get('zoneAdmin') != null) && $session->get('zoneAdmin'))
                {
                    $this->setAdminMenu($menus);
                    $admin = true;
                }
            }
            return array('menus' => $menus,'literie_admin' => $admin);
        }return array(false);
         /**
         * A décommenter
         * pour la prod a la place de ce qu'il y avait avant
         **/
/**
        $menus = $this->getMenuFromRepo('left','Menu');
        $admin = false;
        if ($this->secure->isGranted('ROLE_ADMIN'))
        {
            $admin = true;
            $this->setAdminMenu($menus);
        }
        return array('menus' => $menus,'literie_admin' => $admin);
 */
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
    private function getMenuFromRepo($position, $menu)
    {
        if ($position == 'left')
        {
            $fn = 'getLeft'.$menu;
        }else if ($position == 'right')
        {
            $fn = 'getRight'.$menu;
        }
        /**
         * A enlever $site
         * Et aussi dans MenuRepo
         */
        $site = 1;
        return $this->container->get('doctrine.orm.default_entity_manager')->getRepository('yomaahBundle:'.$menu)->$fn($site);
    }

}
