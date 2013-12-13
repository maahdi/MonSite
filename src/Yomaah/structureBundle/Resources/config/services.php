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
$container->setDefinition(
    'gestionMenu',
    new Definition ('Yomaah\structureBundle\Classes\GestionMenu',array(new Reference('doctrine.orm.entity_manager'),new Reference('security.context')))
);
