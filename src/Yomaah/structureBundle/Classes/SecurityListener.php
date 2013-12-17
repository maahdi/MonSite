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



class SecurityListener implements EventSubscriberInterface
{
    private $secure;
    private $router;
    private $dispatcher;
    private $db;

    public function __construct(SecurityContextInterface $secure, Router $router, EventDispatcher $dispatch, $db)
    {
        $this->db = $db;
        $this->secure = $secure;
        $this->dispatcher = $dispatch;
        $this->router = $router;
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
                    $this->createTestEnvironnement();
                    $response = new RedirectResponse($this->router->generate('test_accueil'));
                    $event->setResponse($response);
                }
            }
        }
    }
    public static function getSubscribedEvents()
    {
        return array('security.interactive_login' => array(array('onSecurityInteractiveLogin',18)));
    }

    private function createTestEnvironnement()
    {
        $sql = array(
            'INSERT INTO `pageTest` (`pageId`,`pageUrl`) VALUES (1,\'accueil\'),(2,\'default\');',
            'INSERT INTO `articleTest` (`id`, `artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`) VALUES
            (1,1,\'Mon Titre\',\'<p>Ceci est un article</p>\',4,Now(),1,NULL,NULL,NULL),
                (2, 2, \'Mon titre\', \'<p>Mon texte ici ...</p>\', 3, NULL, 2, NULL, NULL, NULL);',
            'INSERT INTO `menuTest` (`id`, `path`, `name`, `position`) VALUES
            (1, \'accueil\',\'Accueil\', b\'0\');');
        foreach($sql as $query)
        {
            $this->db->query($query);
        }
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

