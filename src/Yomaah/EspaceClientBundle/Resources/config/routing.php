<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('espace_client_accueil', new Route('/espace-client', array(
    '_controller' => 'YomaahEspaceClientBundle:Main:accueil',
)));

$collection->add('espace_client_connexion', new Route('/espace-client/connexion/{site}',array(
    '_controller' => 'YomaahEspaceClientBundle:Main:getSite',
)));

$collection->add('espace_client_admin', new Route('/espace-client-admin/',array(
    '_controller' => 'YomaahEspaceClientBundle:Main:accueilAdmin',
)));

return $collection;
