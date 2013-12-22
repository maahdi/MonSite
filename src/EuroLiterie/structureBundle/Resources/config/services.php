<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'euro_literiestructure.example',
    new Definition(
        'EuroLiterie\structureBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/
$container->setDefinition('literie_gestionMenu',
    new Definition ('EuroLiterie\structureBundle\Classes\GestionMenu',
        array(new Reference('service_container')))
);

$mobileDetect = new Definition('EuroLiterie\structureBundle\Classes\MobileDetect',array(new Reference('session'),new Reference('request')));
$mobileDetect->addTag('kernel.event_listener', array('event' => 'kernel.request', 'method' => 'onKernelRequest'));
$container->setDefinition('literie_mobile_detect',$mobileDetect)->setScope('request');

$menutwig = new Definition('EuroLiterie\structureBundle\Classes\MenuTwigExtension',array(new Reference('literie_gestionMenu')));
$menutwig->addTag('twig.extension');
$container->setDefinition('literie_menuTwigExtension',$menutwig);
