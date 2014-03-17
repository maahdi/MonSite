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

$collection->add('ajax_adminInterface', new Route('/ajax/adminInterface', array(
    '_controller' => 'YomaahajaxBundle:Ajax:getAdminInterface'),
    array('_method' => 'POST')));

$collection->add('ajax_getAdminContent', new Route('/ajax/adminContent', array(
    '_controller' => 'YomaahajaxBundle:Ajax:getAdminContent'),
    array('_method' => 'GET')));

$collection->add('ajax_getAdminContentStructure', new Route('/ajax/adminContentStructure', array(
    '_controller' => 'YomaahajaxBundle:Ajax:getAdminContentStructure'),
    array('_method' => 'POST')));

$collection->add('ajax_saveElement', new Route('/ajax/saveElement', array(
    '_controller' => 'YomaahajaxBundle:Ajax:saveElement'),
    array('_method' => 'POST')));

$collection->add('ajax_deleteElement', new Route('/ajax/deleteElement', array(
    '_controller' => 'YomaahajaxBundle:Ajax:deleteElement'),
    array('_method' => 'POST')));

$collection->add('ajax_addElement', new Route('/ajax/addElement', array(
    '_controller' => 'YomaahajaxBundle:Ajax:addElement'),
    array('_method' => 'GET')));

$collection->add('ajax_imagesAdminStructure', new Route('/ajax/imagesAdminStructure', array(
    '_controller' => 'YomaahajaxBundle:Ajax:imagesAdminStructure'),
    array('_method' => 'POST')));

$collection->add('ajax_imagesAdmin', new Route('/ajax/imagesAdmin', array(
    '_controller' => 'YomaahajaxBundle:Ajax:imagesAdmin'),
    array('_method' => 'GET')));
return $collection;
