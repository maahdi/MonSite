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

    public function getClientMenu($name)
    {
        $menus = $this->getMenu('left', 'Menu', 'client');
        if ($name == 'clientAdmin')
        {
            $this->setAdminMenu($menus);
            return $this->getParam($name, $menus);
        }else
        {
            return $this->getParam($name, $menus);
        }
    }

    public function getAllMenu()
    {
        if (!($this->dispatcher->testException()))
        {
            if ($this->dispatcher->isClientSite() === true)
            {
                if ($this->dispatcher->isAdmin())
                {
                    $menu = $this->getClientMenu('clientAdmin');
                }else
                {
                    $menu = $this->getClientMenu('normalClient');
                }
                $menuP = $this->getMenuPrincipal('normal', array('connect' => true));
                return array_merge($menuP, $menu);
                /**
                 * Si on est sur le site principal
                 */
            }else if($this->dispatcher->isClientSite() === false)
            {
                if ($this->dispatcher->isAdmin())
                {
                    return $this->getMenuPrincipal('admin');
                }else
                {
                    return $this->getMenuPrincipal('normal');
                }
            }else if ($this->dispatcher->isClientSite() == null)
            {
                    return $this->getClientMenu('normal');
            }

        }else
        {
            /**
             * Voir pour la gestion des erreurs
             */
            //if ($this->dispatcher->isClientSite())
            //{
                //return $this->getClientMenu('erreur');
            //}else if (!($this->dispatcher->isClientSite()))
            //{
                //return $this->getMenuPrincipal('erreur');
            //}
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
            $mLeft = $this->getMenu('left','Menu');
            $mRight = $this->getMenu('right','Menu');
            $this->setAdminMenu($mLeft);
            $menus['left'] = $mLeft;
            $menus['right'] = $mRight;
            return $this->getParam('admin', $menus, $append);
            
        }else if ($name == 'test')
        {
            $mLeft = $this->getMenu('left','MenuTest', 'visiteur', $this->dispatcher->getIdSite());
            $mRight = $this->getMenu('right','Menu');
            $this->setTestMenu($mLeft);
            $menus['left'] = $mLeft;
            $menus['right'] = $mRight;
            return $this->getParam('admin', $menus, $append);
        }else
        {
            $mLeft = $this->getMenu('left','Menu');
            $mRight = $this->getMenu('right','Menu');
            $menus['left'] = $mLeft;
            $menus['right'] = $mRight;
            return $this->getParam('normal', $menus, $append);
        }

    }

    private function getParam($mode, $menus, Array $append = null)
    {
        if ($mode == 'admin')
        {
            $visite = $this->getVisite();
            $retour = array('menus' => $menus,'connect' => true,'visite' => $visite);
        }else if ($mode == 'clientAdmin')
        {
            $visite = $this->getVisite();
            $retour = array('menusClient' => $menus,'connectClient' => true, 'visite' => $visite);
        }else if ($mode == 'normalClient')
        {
            $retour = array('menusClient' => $menus,'connectClient' => false);
        }else if ($mode == 'normal')
        {
            $retour = array('menus' => $menus,'connect' => false);
        }else if ($mode == 'erreur')
        {
            $retour = array('menus' => $menus,'connect' => false, 'position' => 'Erreur');
        }
        if ($append != null)
        {
            return array_merge($retour, $append);
        }else
        {
            return $retour;
        }
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
            $i++;
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

    private function getMenu($position, $menu, $role = null, $token = null)
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
            return $this->em->getRepository('yomaahBundle:'.$menu)->$fn();
        }else if ($role == 'visiteur')
        {
            return $this->em->getRepository('yomaahBundle:'.$menu)->$fn($token);
        }else if ( $role == 'client')
        {
            $id = $this->dispatcher->getIdSite();
            return $this->em->getRepository('yomaahBundle:'.$menu)->$fn($id);
            
        }    
    }

}
