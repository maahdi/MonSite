<?php
namespace Yomaah\structureBundle\Classes;


use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Possibilité ajout test si une fonction existe dans les controllers
 */
class BundleDispatcher
{
    /**
     * Liste des controllers avec leurs bundles
     */
    private $controllers;

    /**
     * Nom du dossier ou se situent les bundles du site
     */
    private $sitePath;
    private $site;
    private $deployed;
    private $admin;
    private $secure;
    private $idSite;
    private $session;

    public function __construct(SecurityContextInterface $secure, Session $session)
    {
        /**
         * changer en prod
         * $this->site = 'site';
         * $this->deployed = true;
         */
        $this->site = 'yomaah';
        $this->deployed = false;

        $this->session = $session;
        $this->secure = $secure;
        $this->idSite = null;
        $this->admin = false;
        if ($secure->getToken() != null)
        {
            $user = $secure->getToken()->getUser();
            if ($this->deployed)
            {
                if ($secure->isGranted('ROLE_ADMIN'))
                {
                    $this->admin = true;
                }
            }else
            {
                
                if ($this->session->has('idSite') && $this->session->has('site'))
                {
                    $this->idSite = $this->session->get('idSite');
                    $this->site = $this->session->get('site');
                }
                if ($this->secure->isGranted('SUPER_ROLE_ADMIN'))
                {
                    if ($this->session->has('siteAdmin') && $this->session->has('zoneAdmin'))
                    {
                        if ($this->session->get('siteAdmin') && $this->session->get('zoneAdmin'))
                        {
                            $this->admin = true;
                        }
                    }
                    
                }else if ($this->secure->isGranted('ROLE_ADMIN'))
                {
                    if ($this->session->has('zoneAdmin'))
                    {
                        $this->admin = true;
                    }
                }
            }
        }
                //$this->site = 'literie';
                //if ($this->secure->isGranted('ROLE_ADMIN'))
                //{
                    //$this->admin = true;
                //}
            //}else
            //{
                //if ($secure->isGranted('ROLE_SUPER_ADMIN'))
                //{
                    ////siteAdmin créer artificiellement pour l'instant
                    //// normalement défini en choississant le projet du client 
                    /**
                     * Si admin sur le site client
                     * mais deja connecté sur le compte super_admin
                     */
                    //if ($session->has('siteAdmin') && $session->has('zoneAdmin'))
                    //{
                        //$this->admin = true;
                        //$this->site = $session->get('siteAdmin');
                        //$this->idSite = $session->get('idSite');
                        /**
                         * Si non-admin sur le site du client
                         * Mais accès en étant connecté en super_admin
                         */
                    //}else if ($session->has('siteAdmin'))
                    //{
                        //$this->idSite = $session->get('idSite');
                        //$this->site = $session->get('siteAdmin');
                        /**
                         * Si connecter juste sur le site principal
                         * 
                         */
                    //}else
                    //{
                        //$this->admin = true;
                        //$this->site = 'yomaah';
                        //$this->idSite = null;
                    //}
                //}else if ($secure->isGranted('ROLE_ADMIN') && $session->has('site'))
                //{
                    //if ($session->has('zoneAdmin'))
                    //{
                        //$this->idSite = $session->get('idSite');
                        //$this->site = $session->get('site');
                        //$this->admin = true;
                    //}else
                    //{
                        //$this->idSite = $session->get('idSite');
                        //$this->site = $session->get('site');
                    //}
                //}else if ($secure->isGranted('ROLE_USER'))
                //{
                    //$this->site = 'test';
                    //$this->idSite = $session->get('testToken');
                    //$this->admin = true;
                //}else
                //{
                    //$this->site = 'yomaah';
                    //$this->idSite = null;
                //}
            //}
        //}else
        //{
            //if ($this->deployed)
            //{
                //$this->site = 'literie';
            //}else
            //{
                //$this->site = 'yomaah';
            //}
        //}
        //var_dump($this->site);
        //var_dump($this->admin);
        //var_dump($this->isTestSite());
        //var_dump($this->isClientSite());
        //var_dump($this->testException());
        //var_dump($this->getIdSite());
        /**
         * Garder controller du site déployé
         */
        $this->controllers = $this->constructControllers();
        $this->sitePath = $this->constructSitePath();
    }

    public function unsetSite()
    {
        $this->site = 'yomaah';
        $this->idSite = null;
        if ($this->session->has('site') && $this->session->has('idSite'))
        {
            $this->session->remove('site');
            $this->session->remove('idSite');
        }
    }
    public function getSite()
    {
        return $this->site;
    }

    public function getIdSite()
    {
        if ($this->deployed)
        {
            return false;
        }else
        {
            return $this->idSite;
        }
    }

    public function setSite($site)
    {
        $this->site = $site;
        if ($this->session->has('site') === false)
        {
            $this->session->set('site', $site);
        }
        return $this;
    }

    public function setIdSite($idSite)
    {
        $this->idSite = $idSite;
        if ($this->session->has('idSite') === false)
        {
            $this->session->set('idSite', $idSite);
        }
    }

    public function testException()
    {
        if ($this->secure->getToken() == null)
        {
            return true;
        }else
        {
            return false;
        }
    }

    /**
     * Controller a appeler en fonction du site
     * Possibilité de diviser avec un sous-tableau
     * Si séparation en plusieurs controllers
     * (actuellement utilisé juste pour les méthodes ajax)
     */
    private function constructControllers()
    {
        $controllers['literie'] = 'structureBundle';
        $controllers['yomaah'] = 'structureBundle';
        return $controllers;
    }

    private function constructSitePath()
    {
        $sitePath['literie'] = 'EuroLiterie';
        $sitePath['yomaah'] = 'Yomaah';
        return $sitePath;
    }

    public function getDeployed()
    {
        return $this->deployed;
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    private function test()
    {
        if (array_key_exists($this->site, $this->sitePath) && array_key_exists($this->site, $this->sitePath)
            && $this->isClientSite())
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function getSitePath()
    {
        return $this->sitePath[$this->site];
    }



    public function isTestSite()
    {
        if ($this->site == 'test')
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function isClientSite()
    {
        if ($this->site == 'yomaah')
        {
            return false;
        }else if ($this->site != 'test')
        {
            return true;
        }else
        {
            return $this->site;
        }
    }
    public function getControllers()
    {
        return $this->controllers[$this->site];
    }

    public function getControllerPath()
    {
        if ($this->test())
        {
            return $this->getSitePath().$this->getControllers().':';
        }else
        {
            return false;
        }
    }


}
