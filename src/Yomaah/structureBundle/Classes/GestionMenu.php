<?php
namespace Yomaah\structureBundle\Classes;

use Yomaah\structureBundle\Classes\BundleDispatcher;
/**
 * Classe pour remplir les menus
 * Utilisé par MenuTwigExtension
 *
 **/
class GestionMenu
{
    private $em;
    private $dispatcher;
    private $db;

    public function __construct(\Doctrine\ORM\EntityManager $em, BundleDispatcher $dispatcher, \Doctrine\DBAL\Connection $db)
    {
        $this->dispatcher = $dispatcher;
        $this->em = $em;
        $this->db = $db;
    }

    public function getClientMenu($name, $append = null)
    {
        $menus = $this->getMenu('left', 'Menu');
        if ($name == 'clientAdmin')
        {
            $this->setAdminMenu($menus);
        }
        return $this->getParam($name, $menus, $append);
    }

    public function getAllMenu()
    {
        if (!($this->dispatcher->testException()))
        {

            if ($this->dispatcher->isClientSite() && $this->dispatcher->getDeployed() === false)
            {
                if ($this->dispatcher->isAdmin())
                {
                    $menu = $this->getClientMenu('clientAdmin');
                }else
                {
                    $menu = $this->getClientMenu('normalClient');
                }
                if ($this->dispatcher->isSuperAdmin())
                {
                    $menuP = $this->getMenuPrincipal('admin');
                }else
                {
                    $menuP = $this->getMenuPrincipal('normal');
                }
                return array_merge($menuP, $menu);
                /**
                 * Si on est sur le site principal
                 */
            }else if ($this->dispatcher->isClientSite() && $this->dispatcher->getDeployed())
            {
                if ($this->dispatcher->isAdmin())
                {
                    return $menu = $this->getClientMenu('clientAdmin');
                }else
                {
                    return $menu = $this->getClientMenu('normalClient');
                }
            }else if ($this->dispatcher->isClientSite() === null)
            {
                    return $this->getTestMenu('normal');

            }else if ($this->dispatcher->isClientSite() === false)
            {
                if ($this->dispatcher->isAdmin())
                {
                    return $this->getMenuPrincipal('admin');
                }else
                {
                    return $this->getMenuPrincipal('normal', array('connectClient' => true));
                }
            }

        }else
        {
            //if ($this->dispatcher->isClientSite() && $this->dispatcher->isAdmin())
            //{
                //return $this->getClientMenu('clientAdmin');

            //}else if ($this->dispatcher->isClientSite() && $this->dispatcher->isAdmin() === false)
            //{
                //return $this->getClientMenu('normalClient');
                
            //}
            if ($this->dispatcher->getDeployed() === false)
            {
                if ($this->dispatcher->isAdmin() && $this->dispatcher->isClientSite() && $this->dispatcher->isSuperAdmin() === false)
                {
                    $menu = $this->getClientMenu('clientAdmin');
                    $menuP = $this->getMenuPrincipal('erreur', array('connectClient' => true, 'connect' => true));

                }else if ($this->dispatcher->isAdmin() === false && $this->dispatcher->isClientSite())
                {
                    $menu = $this->getClientMenu('normalClient');
                    $menuP = $this->getMenuPrincipal('erreur', array('connectClient' => true, 'connect' => true));

                }else if ($this->dispatcher->isAdmin() && $this->dispatcher->isClientSite() === false)
                {
                    $menu = array();
                    $menuP = $this->getMenuPrincipal('erreur', array('connectClient' => true));

                }else if ($this->dispatcher->isAdmin() === false && $this->dispatcher->isClientSite() === false)
                {
                    $menu = array();
                    $menuP = $this->getMenuPrincipal('erreur');
                    
                }else if ($this->dispatcher->isSuperAdmin())
                {
                    $menu = array();
                    $menuP = $this->getMenuPrincipal('admin');

                }
                return array_merge($menuP, $menu);
            }
        }
    }

    public function getTestMenu()
    {
        return $this->getMenuPrincipal('test');
    }


    public function getMenuPrincipal($name, Array $append = null)
    {
        if ($name == 'admin')
        {
            $mLeft = $this->getMenu('left','Menu', true);
            $mRight = $this->getMenu('right','Menu', true);
            $this->setAdminMenu($mLeft);
            $menus['left'] = $mLeft;
            $menus['right'] = $mRight;
            return $this->getParam('admin', $menus, $append);
            
        }else if ($name == 'test')
        {
            $mLeft = $this->getMenu('left','MenuTest',true);
            $mRight = $this->getMenu('right','Menu', true);
            $this->setTestMenu($mLeft);
            $menus['left'] = $mLeft;
            $menus['right'] = $mRight;
            return $this->getParam('admin', $menus, $append);

        }else
        {
            $mLeft = $this->getMenu('left','Menu', true);
            $mRight = $this->getMenu('right','Menu', true);
            $menus['left'] = $mLeft;
            $menus['right'] = $mRight;
            return $this->getParam($name, $menus, $append);
        }

    }

    /*
     * connect = pour modification affichage des personnes connectées
     * connectClient = pour affichage des clients connectés
     * connectAdmin = pour intégration des fichiers pour l'interface admin template Yomaah
     */
    private function getParam($mode, $menus, Array $append = null)
    {
        if ($mode == 'admin')
        {
            $visite = $this->getVisite();
            $retour = array('menus' => $menus, 'connectAdmin' => true,'visite' => $visite);

        }else if ($mode == 'clientAdmin')
        {
            $visite = $this->getVisite();
            $retour = array('menusClient' => $menus, 'connectClient' => true, 'visite' => $visite);

        }else if ($mode == 'normalClient')
        {
            $retour = array('menusClient' => $menus, 'connectClient' => false);

        }else if ($mode == 'normal')
        {
            $retour = array('menus' => $menus);

        }else if ($mode == 'erreur')
        {
            $retour = array('menus' => $menus, 'position' => 'Erreur');
        }
        if ($this->dispatcher->testException() === false)
        {
            if (!(isset($retour['connect'])) && $this->dispatcher->isAuthenticated())
            {
                $retour['connect'] = true;
            } 
        }
        if ($append != null)
        {
            $keys = array_keys($append);
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $retour))
                {
                    $retour[$key] = $append[$key];
                }else
                {
                    $retour = array_merge($retour, $append);
                }
            }
        }
        return $retour;
    }

    private function setAdminMenu($menu)
    {
        foreach ($menu as $m)
        {
            if (preg_match('/admin_/', $m->getPath()) == 0)
            {
                $m->setPath('admin_'.$m->getPath());
            }
        }
    }

    private function setTestMenu($menu)
    {
        foreach ($menu as $m)
        {
            $m->setPath('test_'.$m->getPath());
        }
    }

    private function getVisite()
    {
        $sql = 'select count(idVisite) as nb from visites as v left join utilisateur as u on v.idUser = u.idUser where u.idGroup !=1 and v.idUser = 0';
        $result = $this->db->query($sql);
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $visite['total'] = $r->nb;
        }
        $sql = 'select count(idVisite) as nb from visites as v left join utilisateur as u on v.idUser = u.idUser where extract( month from current_date) = extract( month from dateConnexion) and (u.idGroup != 1 and v.idUser = 0)';
        $result = $this->db->query($sql);
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $visite['mois'] = $r->nb;
        }
        return $visite;

    }

    private function getMenu($position, $menu, $origin = null)
    {
        if ($position == 'left')
        {
            $fn = 'getLeft'.$menu;

        }else if ($position == 'right')
        {
            $fn = 'getRight'.$menu;
        }
        if ($origin)
        {
            $param['idSite'] = null;
        }else
        {
            $param['idSite'] = $this->dispatcher->getIdSite();
        }
        if ($this->dispatcher->isTestSite())
        {
            $param['token'] = $this->dispatcher->getIdSite();
        }
        return $this->em->getRepository('yomaahBundle:'.$menu)->$fn($param);
    }

}
