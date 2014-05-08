<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('yomaah_login', new Route('/login', array(
    '_controller' => 'YomaahconnexionBundle:Connexion:login',
)));

$collection->add('admin_login', new Route('/admin', array(
    '_controller' => 'YomaahconnexionBundle:Connexion:login',
)));
$collection->add('login_check', new Route('/login_check',array()));
$collection->add('logout', new Route('/logout',array()));

$collection->add('admin_test', new Route('/testFunction', array(
    '_controller' => 'YomaahconnexionBundle:Connexion:test',
)));
return $collection;
