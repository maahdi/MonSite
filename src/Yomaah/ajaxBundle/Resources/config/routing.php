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

$collection->add('ajax_logoAdminStructure', new Route('/ajax/logoAdminStructure', array(
    '_controller' => 'YomaahajaxBundle:Ajax:logoAdminStructure'),
    array('_method' => 'POST')));

$collection->add('ajax_saveImage', new Route('/ajax/saveImage', array(
    '_controller' => 'YomaahajaxBundle:Ajax:saveImage'),
    array('_method' => 'POST')));

$collection->add('ajax_uploadImage', new Route('/ajax/uploadImage', array(
    '_controller' => 'YomaahajaxBundle:Ajax:uploadImage'),
    array('_method' => 'POST')));

$collection->add('ajax_deleteImage', new Route('/ajax/deleteImage', array(
    '_controller' => 'YomaahajaxBundle:Ajax:deleteImage'),
    array('_method' => 'POST')));

$collection->add('ajax_imagesSearch', new Route('/ajax/imagesSearch', array(
    '_controller' => 'YomaahajaxBundle:Ajax:imagesSearch'),
    array('_method' => 'GET')));

$collection->add('ajax_atteindre', new Route('/ajax/atteindre', array(
    '_controller' => 'YomaahajaxBundle:Ajax:atteindre'),
    array('_method' => 'POST')));
return $collection;
