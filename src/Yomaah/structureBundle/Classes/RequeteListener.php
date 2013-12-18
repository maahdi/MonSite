<?php

namespace Yomaah\structureBundle\Classes;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
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

    public function __construct(\Doctrine\DBAL\Connection $db,SecurityContextInterface $secure)
    {
        $this->db = $db;
        $this->secure = $secure;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $sql = 'select max(dateConnexion) as date,adresseIp from visites where adresseIp = ?';
        //$sql = 'select dateConnexion as date,adresseIp from visites where adresseIp = ? and dateConnexion = (select max(dateConnexion) from visites)';
        $request = $event->getRequest();
        $ip = $request->getClientIp();
        $result = $this->db->executeQuery($sql,array($ip));
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $date = new \Datetime($r->date);
        }
        if (($this->secure->getToken()->getUser() == "anon.") && ($result->rowCount() == 0))
        {
            $insert = 'insert into visites (adresseIp, dateConnexion) values (?,Now())';
            $this->db->executeQuery($insert, array($ip));
        }else if (($this->secure->getToken()->getUser() == "anon.") && ($result->rowCount() == 1))
        {
            $date = $this->testDate($date);
            if (!($date === false))
            {
                $insert = 'insert into visites (adresseIp, dateConnexion) values (?,?)';
                $this->db->executeQuery($insert, array($ip, $date),array('string', 'datetime'));
            }
        }else if ($this->secure->isGranted('ROLE_SUPER_ADMIN'))
        {
            $id = $this->secure->getToken()->getUser()->getId();
            $sql = 'update visites set idUser = ? where adresseIp = ?';
            $this->db->executeQuery($sql, array($id, $ip));
        }else        
        {
            $id = $this->secure->getToken()->getUser()->getId();
            $sql = 'update visites set idUser = ? where adresseIp = ? and dateConnexion = ?';
            $this->db->executeQuery($sql, array($id, $ip, $date->format('Y-m-d H:i:s')));
        }
    } 


    public function testDate($date)
    {
        $dateNow = new \Datetime();
        $diff = $date->diff($dateNow);
        if ($diff->h >= 12 || $diff->d > 1)
        {
            return $dateNow;
        }else
        {
            return false;
        }
        
    }

    /**
     * Pas de compteur dans un fichier
     * Enregistrement de tous les ip et dates de connexion différentes
     * Comptage au moment de l'affichage
     * Exclusion ip administrateur plus tard pour alléger la base
     *
     **/
    public function incrementCompteur()
    {
        $fichier = fopen(__DIR__.'/compteur.txt','r+');
        while (!feof($fichier))
        {
            $buffer = fgets($fichier,4096);
            if ($buffer !== false)
            {
                $compteur = (int) $buffer;
                $compteur +=1;
            }
        }
        fseek($fichier,0);
        ftruncate($fichier,0);
        fwrite($fichier,(string) $compteur);
        fclose($fichier);
    }

    private function decrementCompteur()
    {
        $fichier = fopen(__DIR__.'/compteur.txt','r+');
        while (!feof($fichier))
        {
            $buffer = fgets($fichier,4096);
            if ($buffer !== false)
            {
                $compteur = (int) $buffer;
                $compteur -=1;
            }
        }
        fseek($fichier,0);
        ftruncate($fichier,0);
        fwrite($fichier,(string) $compteur);
        fclose($fichier);
    }
    
}
