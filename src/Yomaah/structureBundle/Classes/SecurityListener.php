<?php
namespace Yomaah\structureBundle\Classes;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Le listener est utilisé quand un utilisateur se log
 * Si l'utilisateur est du groupe visiteur
 * il est basculé sur la page de test
 * Cette classe crée aussi l'environnement de test
 * en prenant compte des multiples accès en même temps
 *
 **/
class SecurityListener implements EventSubscriberInterface
{
    private $secure;
    private $router;
    private $dispatcher;
    private $session;

    public function __construct(SecurityContextInterface $secure, Router $router, EventDispatcher $dispatch, \Doctrine\DBAL\Connection $db, Session $session)
    {
        $this->db = $db;
        $this->secure = $secure;
        $this->dispatcher = $dispatch;
        $this->router = $router;
        $this->session = $session;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->dispatcher->addListener(KernelEvents::RESPONSE, array($this, 'redirectUser'));
    }

    public function redirectUser(FilterResponseEvent $event)
    {
        if ($this->secure->getToken()->isAuthenticated()){
            $role = $this->secure->getToken()->getUser()->getRoles();
            if ($role != "anon."){
                if ($role[0] == "visiteur")
                {
                    /**
                     * Cette portion de code définit un token générique si la base est vide
                     * ou un nouveau si quelqu'un est en train de tester
                     *
                     **/
                    $sql = 'select max(token) as token from menuTest';
                    $result = $this->db->query($sql);
                    $result->setFetchMode(\PDO::FETCH_OBJ);
                    if ($result->rowCount() > 0)
                    {
                        foreach ($result as $r)
                        {
                            if ($r->token != null)
                            {
                                $token = $r->token + 1;
                            }else
                            {
                                $token = 10;
                            }
                        }
                    }
                    $this->session->set('testToken' , $token);
                    $this->createTestEnvironnement($token);
                    $response = new RedirectResponse($this->router->generate('test_accueil'));
                    $event->setResponse($response);
                }else
                {
                    /**
                     * Pour l'instant en se connectant un utilisateur lié a un site creer une session
                     * Pour le futur plusieurs sites pourront être lié à un utilisateur
                     */
                    $sql = 'select nomSite from site where idUser = ? ';
                    $result = $this->db->executeQuery($sql, array($this->secure->getToken()->getUser()->getIdUser()));
                    $result->setFetchMode(\PDO::FETCH_OBJ);
                    foreach ($result as $r)
                    {
                        if ($r != null)
                        {
                            $this->session->set('site', $r->nomSite);
                        }
                    }
                }                    
            }
            /*
             * Ajouter retour reponse vers la page qu'on veut
             */
        }
    }

    public static function getSubscribedEvents()
    {
        return array('security.interactive_login' => array(array('onSecurityInteractiveLogin',18)));
    }

    private function createTestEnvironnement($token)
    {
        // Ajouter selection selon session active
        $test = 'select * from articleTest';
        $result = $this->db->query($test);
        if ($result->rowCount() > 0)
        {
            /**
             * Nettoyer la base sur les sessions inactives
             *
             **/
            //$sql = array('delete from menuTest','delete from articleTest','delete from pageTest');
            //foreach ($sql as $query)
            //{
                //$this->db->query($query);
            //}
            
        }
        $sql = array(
            'INSERT INTO `pageTest` (`pageUrl`,`token`) VALUES (\'default\',?),(\'accueil\',?);',
            'INSERT INTO `articleTest` (`artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`,`token`) VALUES
            (1,\'Mon Titre\',\'<p>Ceci est un article</p>\',4,Now(),(select pageId from pageTest where pageUrl = \'accueil\' and token = ?),NULL,NULL,NULL,?)',
                 'INSERT INTO `articleTest` (`artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`,`token`) VALUES(2, \'Mon titre\', \'<p>Mon texte ici ...</p>\', 3, NULL, (select pageId from pageTest where pageUrl = \'default\' and token = ?), NULL, NULL, NULL,?);');
        foreach($sql as $query)
        {
            $this->db->executeQuery($query,array($token, $token));
        }
        $sql = 'INSERT INTO `menuTest` (`path`, `name`, `position`,`token`) VALUES (\'accueil\',\'Accueil\', b\'0\',?);';
        $this->db->executeQuery($sql, array($token));
    }
}
//'CREATE TABLE IF NOT EXISTS `articleTest` (
              //`id` int(11) NOT NULL AUTO_INCREMENT,
              //`artId` int(11) DEFAULT NULL,
              //`artTitle` varchar(80) COLLATE utf8_bin NOT NULL,
              //`artContent` text COLLATE utf8_bin NOT NULL,
              //`artPngId` int(11) DEFAULT NULL,
              //`artDate` date DEFAULT NULL,
              //`artPageId` int(11) DEFAULT NULL,
              //`artImgUrl` varchar(70) COLLATE utf8_bin DEFAULT NULL,
              //`artSource` varchar(100) COLLATE utf8_bin DEFAULT NULL,
              //`artLien` varchar(100) COLLATE utf8_bin DEFAULT NULL,
              //PRIMARY KEY (`id`),
              //UNIQUE KEY `artId` (`artId`),
              //KEY `art-png-id` (`artPngId`),
              //KEY `art-page-id` (`artPageId`)
          //) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=43 ;',
            //'CREATE TABLE IF NOT EXISTS `pageTest` (
              //`pageId` int(11) NOT NULL,
              //`pageUrl` varchar(50) COLLATE utf8_bin NOT NULL,
              //PRIMARY KEY (`pageId`)
          //) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;',
            //'CREATE TABLE IF NOT EXISTS `menuTest` (
              //`id` int(11) NOT NULL AUTO_INCREMENT,
              //`path` varchar(20) COLLATE utf8_bin NOT NULL,
              //`name` varchar(20) COLLATE utf8_bin NOT NULL,
              //`position` bit(1) NOT NULL,
              //PRIMARY KEY (`id`)
          //) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;',

