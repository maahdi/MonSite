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

    public function __construct(SecurityContext $secure, Session $session)
    {
        /**
         * Mettre a true en prod
         */
        $deployed = false;
        $user = $secure->getToken()->getUser();
        if ($secure->getToken() != null)
        {
            if ($deployed)
            {
                $this->site = '';
            }else
            {
                if ($secure->isGranted('ROLE_SUPER_ADMIN'))
                {
                    if ($session->has('siteAdmin'))
                    {
                        $this->site = $session->get('siteAdmin');
                    }else
                    {
                        $this->site = 'yomaah';
                    }
                }else if ($secure->isGranted('ROLE_ADMIN'))
                {
                    $this->site = $session->get('site');
                }else if ($secure->isGranted('ROLE_USER'))
                {
                    $this->site = 'test';
                }
            }
        }else
        {
            // quelque chose à mettre pour exception
        }
        //if ($session->has('site'))
        //{
            //$this->site = $session->get('site');
        //}else if ($session->has('testToken'))
        //{
            //$this->site = 'test';
        //}else
        //{
            /**
             * Changer variable par valeur du site déployé
             * supprimer ce qu'il y a avant
             */
            //$this->site = 'yomaah';
        //}
        /**
         * Garder controller du site déployé
         */
        $this->controllers = $this->constructControllers();
        $this->sitePath = $this->constructSitePath();
    }


    /**
     * Controller a appeler en fonction du site
     * Possibilité de diviser avec un sous-tableau
     * Si séparation en plusieurs controllers
     * (actuellement utilisé juste pour les méthodes ajax)
     */
    private function constructControllers()
    {
        $controllers['literie'] = 'structureBundle:Main';
        return $controllers;
    }

    private function constructSitePath()
    {
        $sitePath['literie'] = 'EuroLiterie';
        return $sitePath;
    }

    private function test()
    {
        if (array_key_exists($this->site, $this->sitePath) && array_key_exists($this->site, $this->sitePath
            && $this->isClientSite()))
        {
            return true;
        }else
        {
            return false;
        }
    }

    private function getSitePath()
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
        if ($this->site == 'yomaah' || $this->site == 'test')
        {
            return false;
        }else
        {
            return true;
        }
    }
    private function getControllers()
    {
        return $this->controllers[$this->site];
    }

    public function getControllerPath()
    {
        if ($this->test())
        {
            return $this->getBundle().$this->getControllers().':';
        }else
        {
            return false;
        }
    }


}
