<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'yomaahcode_source.example',
    new Definition(
        'Yomaah\codeSourceBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);
*/

$container->setDefinition(
    'codeSource',
    new Definition(
        'Yomaah\codeSourceBundle\Controller\CodeSourceController'
    )
);
