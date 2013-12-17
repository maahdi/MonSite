<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('ajax', new Route('/ajax', array(
    '_controller' => 'YomaahajaxBundle:Ajax:updateArticle'),
    array('_method' => 'POST')));

$collection->add('ajax_newArticle', new Route('/ajax/newArticle', array(
    '_controller' => 'YomaahajaxBundle:Ajax:getNewArticle'),
    array('_method' => 'POST')));

$collection->add('ajax_getDialog', new Route('/ajax/dialog', array(
    '_controller' => 'YomaahajaxBundle:Ajax:getDialog'),
    array('_method' => 'POST')));

$collection->add('ajax_deleteArticle', new Route('/ajax/deleteArticle', array(
    '_controller' => 'YomaahajaxBundle:Ajax:deleteArticle'),
    array('_method' => 'POST')));
return $collection;