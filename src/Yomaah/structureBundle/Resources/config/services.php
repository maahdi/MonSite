<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'yomaah.example',
    new Definition(
        'Yomaah\structureBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);


 */
$container->setDefinition('_yomaahController', 
    new Definition('Yomaah\structureBundle\Controller\MainController'));


$gestionErreur= new Definition('Yomaah\structureBundle\Classes\GestionErreur',
    array(new Reference('templating'), new Reference('bundleDispatcher')));
$gestionErreur->addTag('kernel.event_listener',
    array('event' => 'kernel.exception', 'method' => 'onKernelException'));
$container->setDefinition('gestionErreur', $gestionErreur);

$container->setDefinition('gestionMenu',
    new Definition ('Yomaah\structureBundle\Classes\GestionMenu',
        array(new Reference('doctrine.orm.entity_manager'), new Reference('bundleDispatcher'), new Reference('database_connection')))
);

$container->setDefinition('bundleDispatcher',
    new Definition ('Yomaah\structureBundle\Classes\BundleDispatcher',
        array(new Reference('security.context'), new Reference('session')))
);

$menutwig = new Definition('Yomaah\structureBundle\Classes\MenuTwigExtension',
    array(new Reference('gestionMenu')));
$menutwig->addTag('twig.extension');
$container->setDefinition('menuTwigExtension',$menutwig);

$listenerLog = new Definition('Yomaah\structureBundle\Classes\SecurityListener', 
    array(new Reference('security.context'),new Reference('router'),
        new Reference('event_dispatcher'),new Reference('database_connection'), 
        new Reference('session'), new Reference('bundleDispatcher')));
$listenerLog->addTag('kernel.event_subscriber');
$container->setDefinition('yomaah_security_listener',$listenerLog);


$listenerRequete = new Definition('Yomaah\structureBundle\Classes\RequeteListener',
    array(new Reference('bundleDispatcher'), new Reference('router'), new Reference('database_connection'),new Reference('security.context')));
$listenerRequete->addTag('kernel.event_listener', array('event' => 'kernel.request', 'method' => 'onKernelRequest'));
$container->setDefinition('yomaah_requete_listener',$listenerRequete);

$mobileDetect = new Definition('Yomaah\structureBundle\Classes\MobileDetect',
    array(new Reference('session'),new Reference('request')));
$mobileDetect->addTag('kernel.event_listener', 
    array('event' => 'kernel.request', 'method' => 'onKernelRequest'));
$container->setDefinition('mobile_detect',$mobileDetect)->setScope('request');
