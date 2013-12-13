<?php
namespace Yomaah\ajaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SYmfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    public function updateArticleAction ()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $request = $this->container->get('request');
            $article = $this->getDoctrine()->getRepository('yomaahBundle:Article')->find($request->request->get('id'));
            if (($setter = $this->getSetter($request->request->get('champ'))) !== false )
            {
                $article->$setter($request->request->get('content'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                return new Response();
            }else
            {
                return new Response('Erreur mauvais champ !');
            }
        }
    }

    private function getSetter($champ)
    {
        switch ($champ)
        {
        case 'art-titre':
            $setter = 'setArtTitre';
            break;
        case 'art-content':
            $setter = 'setArtContent';
            break;
        default:
            $setter = false;
        }
        return $setter;
    }
}
