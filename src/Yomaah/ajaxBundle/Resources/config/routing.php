<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('ajax', new Route('/ajax', array(
    '_controller' => 'YomaahajaxBundle:Ajax:updateArticle'),
    array('_method' => 'POST')));

return $collection;
