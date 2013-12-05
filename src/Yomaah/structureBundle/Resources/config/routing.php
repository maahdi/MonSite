<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('yomaah_homepage', new Route('/', array(
    '_controller' => 'yomaahBundle:Main:index',
)));

$collection->add('cv', new Route('/cv', array(
    '_controller' => 'yomaahBundle:Main:cv',
)));

$collection->add('projet', new Route('/projets', array(
    '_controller' => 'yomaahBundle:Main:index',
)));

$collection->add('espace_client', new Route('/espace_client', array(
    '_controller' => 'yomaahBundle:Main:espaceClient',
)));
return $collection;
