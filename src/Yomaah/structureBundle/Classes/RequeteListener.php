<?php

namespace Yomaah\structureBundle\Classes;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\Router;
Use Yomaah\structureBundle\Classes\BundleDispatcher;
/**
 * Le listener implemente un compteur de visite
 * en se basant sur l'adresse ip et la date de connexion
 * le compteur est incrémenté quand :
 *      - la date de dernière connexion est supérieure à 12h 
 *      - première visite sur le site
 *
 **/
class RequeteListener
{
    private $db;
    private $secure;
    private $router;
    private $dispatcher;

    public function __construct(BundleDispatcher $dispatcher, Router $router, \Doctrine\DBAL\Connection $db,SecurityContextInterface $secure)
    {
        $this->db = $db;
        $this->dispatcher = $dispatcher;
        $this->secure = $secure;
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Implémenter une erreur si $this->secure->getToken() == null
     * Car a chaque fois sa le fait sur une page sans route
     * Comme c la page avec la première erreur
     * L'appli doit passer d'abord par ce code
     **/
    public function onKernelRequest(GetResponseEvent $event)
    {
		$request = $event->getRequest();
        $pathInfo = $request->getPathInfo();
        $routes = $this->router->match($pathInfo);
        if (preg_match('/web_profiler/', $routes['_controller']) === 0
            && preg_match('/yomaah/', $pathInfo) === 0
            && preg_match('/espace-client/', $pathInfo) === 0
            && preg_match('/post-log/', $pathInfo))
        {

            $this->testRoute($request, $routes);

        }else if (preg_match('/yomaah/', $pathInfo) && $request->getSession()->get('rescueSite'))
        {
            $this->dispatcher->unsetSite();
        }
		/*
		* Passe 2 fois par ce script je pense lors de l'envoi de la toolbar symfony
		*/
		//if (!($request->getSession()->has('secondPass')))
		//{
			//$request->getSession()->set('secondPass',true);
			//$this->setVisite($request);
		//}else if (!($request->getSession()->get('secondPass')))
		//{
			//$this->setVisite($request);
            //$this->testRoute($request);
			//$request->getSession()->set('secondPass',true);
		//}else if ($request->getSession()->has('secondPass'))
		//{
			//$request->getSession()->set('secondPass',false);   
		//}
    } 

    public function testRoute($request, $routes)
    {
        if ($request->getSession()->has('rescueSite')
            && preg_match('/connexion/', $routes['_route']) === 0)
        {
            $url = $routes['_route'];
            $tmp = explode('_', $url);
            if ($this->secure->getToken() != null && $this->secure->isGranted('ROLE_SUPER_ADMIN'))
            {
                $request->getSession()->set('rescueSite', $tmp[0]);
                $this->dispatcher->setSite($tmp[0]);
                $this->dispatcher->setIdSite($this->getIdSite($tmp[0]));
                $request->getSession()->set('rescueIdSite', $this->getIdSite($tmp[0]));

            }else if ($this->secure->getToken() != null && $this->secure->isGranted('ROLE_ADMIN'))
            {
                if ($this->secure->isGranted('ROLE_ADMIN'))
                {
                    $user = $this->secure->getToken()->getUser();
                    foreach($user->getSites() as $s)
                    {
                        if ($s->getNomSite() == $tmp[0])
                        {
                            $request->getSession()->set('rescueSite', $tmp[0]);
                            $request->getSession()->set('rescueIdSite', $s->getIdSite());
                            $this->dispatcher->setSite($tmp[0]);
                            $this->dispatcher->setIdSite($s->getIdSite());
                        }
                    }
                }
            }
            return $this->router->generate($url);
        }
    }
    public function getIdSite($nom)
    {
        $sql = 'select idSite from site where nomSite = ?';
        $result = $this->db->executeQuery($sql, array($nom));
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $idSite = $r->idSite;
        }
        return $idSite;
    }

	public function setVisite($request)
	{
		$sql = 'select max(dateConnexion) as date,adresseIp from visites where adresseIp = ?';
	    $ip = $request->getClientIp();
	    $result = $this->db->executeQuery($sql,array($ip));
	    $result->setFetchMode(\PDO::FETCH_OBJ);
	    foreach ($result as $r)
	    {
			$test = $r->date;
	    }
if ($this->secure->getToken() != null)
{
		$date = new \Datetime($test);

		/**
		* Si visite d'adresse ip inconnu
		*/

	    if (($this->secure->getToken()->getUser() == "anon.") && ($test == null))
	    {
	        $insert = 'insert into visites (adresseIp, dateConnexion) values (?,Now())';
	        $this->db->executeUpdate($insert, array($ip));
		/**
		* Si visite ip connu mais date > 12h
		*/
	    }else if (($this->secure->getToken()->getUser() == "anon.") && ($this->testDate($date)))
	    {
	        $insert = 'insert into visites (adresseIp, dateConnexion) values (?,Now())';
	        $this->db->executeUpdate($insert, array($ip));
		/**
		* Si adresse connu dans tous les cas on associe la visite avec l'admin
		*/
/* A remplacer en prod

}else if ($this->secure->isGranted('ROLE_SUPER_ADMIN') || $this->secure->isGranted('ROLE_ADMIN'))
 */
	    }else if ($this->secure->isGranted('ROLE_SUPER_ADMIN'))
	    {
	        $id = $this->secure->getToken()->getUser()->getIdUser();
	        $sql = 'update visites set idUser = ? where adresseIp = ? and dateConnexion = ?';
	        $this->db->executeUpdate($sql, array($id, $ip, $date->format('Y-m-d H:i:s')));
		/**
		*	Adresse connu et role_user restant
		*	Si la date est supérieure (pas obligatoire car pas de cookie remember me
		*	ie première visite en anonyme forcément enregistré dans le second if)
		*/
	    }else if ($this->testDate($date))
	    {
	        /**
	         * Cette partie pour enregistrer les utilisateurs test
	         * A enlever aussi
	         **/
			$date = new \Datetime($test);
	        $id = $this->secure->getToken()->getUser()->getIdUser();
	        $sql = 'update visites set idUser = ? where adresseIp = ? and dateConnexion = ?';
	        $this->db->executeUpdate($sql, array($id, $ip, $date->format('Y-m-d H:i:s')));
	    }
}
	}
	

    public function testDate($date)
    {
        $dateNow = new \Datetime();
        $diff = $date->diff($dateNow);
        if ($diff->h >= 12 || $diff->d >= 1)
        {
            return true;
        }else
        {
            return false;
        }
        
    }

    /*
     * Pas de compteur dans un fichier
     * Enregistrement de tous les ip et dates de connexion différentes
     * Comptage au moment de l'affichage
     * Exclusion ip administrateur plus tard pour alléger la base
     *
     **/
    //public function incrementCompteur()
    //{
        //$fichier = fopen(__DIR__.'/compteur.txt','r+');
        //while (!feof($fichier))
        //{
            //$buffer = fgets($fichier,4096);
            //if ($buffer !== false)
            //{
                //$compteur = (int) $buffer;
                //$compteur +=1;
            //}
        //}
        //fseek($fichier,0);
        //ftruncate($fichier,0);
        //fwrite($fichier,(string) $compteur);
        //fclose($fichier);
    //}

    //private function decrementCompteur()
    //{
        //$fichier = fopen(__DIR__.'/compteur.txt','r+');
        //while (!feof($fichier))
        //{
            //$buffer = fgets($fichier,4096);
            //if ($buffer !== false)
            //{
                //$compteur = (int) $buffer;
                //$compteur -=1;
            //}
        //}
        //fseek($fichier,0);
        //ftruncate($fichier,0);
        //fwrite($fichier,(string) $compteur);
        //fclose($fichier);
    //}
    
}
