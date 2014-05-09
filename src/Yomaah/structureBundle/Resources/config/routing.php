<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('yomaah_accueil', new Route('/', array(
    '_controller' => 'yomaahBundle:Main:index',
)));

$collection->add('yomaah_cv', new Route('/cv', array(
    '_controller' => 'yomaahBundle:Main:cv',
)));

$collection->add('yomaah_projet', new Route('/projet', array(
    '_controller' => 'yomaahBundle:Main:projet',
)));

$collection->add('espace_client', new Route('/espace_client', array(
    '_controller' => 'yomaahBundle:Main:espaceClient',
)));

$collection->add('yomaah_code_source', new Route('/code_source/{path}', array(
    '_controller' => 'yomaahBundle:Main:codeSource',
    ),array('path'=> '.+')
));

$collection->add('yomaah_code_source_git',new Route('/code_source_git', array(
    '_controller' => 'yomaahBundle:Main:codeSourceGit',)
));

$collection->add('admin_yomaah_accueil', new Route('/admin_accueil', array(
    '_controller' => 'yomaahBundle:Main:index',
)));


$collection->add('admin_yomaah_cv', new Route('/admin_cv', array(
    '_controller' => 'yomaahBundle:Main:cv',
)));

$collection->add('admin_yomaah_projets', new Route('/admin_projets', array(
    '_controller' => 'yomaahBundle:Main:projet',
)));

$collection->add('admin_yomaah_code_source', new Route('/admin_code_source/{path}', array(
    '_controller' => 'yomaahBundle:Main:codeSource',
    ),array('path'=> '.+')
));

$collection->add('admin_yomaah_code_source_git',new Route('/admin_code_source_git', array(
    '_controller' => 'yomaahBundle:Main:codeSourceGit',)
));

$collection->add('test_accueil',new Route('/test/test_accueil', array(
    '_controller' => 'yomaahBundle:Test:accueil')
));
$collection->add('tmpliterie', new Route('/tmpliterie', array(
    '_controller' => 'yomaahBundle:Main:tmpLiterie')));

$collection->add('post_log',new Route('/post_log', array(
    '_controller' => 'yomaahBundle:Main:postLogout',)
));


return $collection;
