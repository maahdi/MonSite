<?php
namespace Yomaah\ajaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    public function updateArticleAction ()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $request = $this->container->get('request');
            $article = $this->getDoctrine()->getRepository('yomaahBundle:Article')->find($request->request->get('id'));
            $getSet = $this->getSetterGetter($request->request->get('champ'));
            $content = $this->clearTitre($request->request->get('champ'), $request->request->get('content'));
            if ($getSet !== false && $content != "")
            {
                if ((substr_compare($article->$getSet['getter'](), $content, 0) != 0))
                {
                    $article->$getSet['setter']($content);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($article);
                    $em->flush();
                    return new Response();
                }else
                {
                    return new Response('Deja enregistré');
                }
            }else if ($content == "")
            {
                return new Response('Le titre ne peut pas être vide !');
            }else
            {
                return new Response('Erreur : mauvais champ !');
            }
        }else if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $request = $this->get('request');
            $article = $this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')->find($request->request->get('id'));
            $getSet = $this->getSetterGetter($request->request->get('champ'));
            $content = $this->clearTitre($request->request->get('champ'), $request->request->get('content'));
            if ($getSet !== false && $content != "")
            {
                if ((substr_compare($article->$getSet['getter'](), $content, 0) != 0))
                {
                    $article->$getSet['setter']($content);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($article);
                    $em->flush();
                    return new Response();
                }else
                {
                    return new Response('Deja enregistré');
                }
            }else if ($content == "")
            {
                return new Response('Le titre ne peut pas être vide !');
            }else
            {
                return new Response('Erreur : mauvais champ !');
            }
        }

    }

    public function deleteArticleAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $request = $this->get('request');
            $em = $this->getDoctrine()->getManager();
            $em->remove($this->getDoctrine()->getRepository('yomaahBundle:Article')->find($request->request->get('id')));
            $em->flush();
            return new Response();
        }else if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $request = $this->get('request');
            $em = $this->getDoctrine()->getManager();
            $em->remove($this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')->find($request->request->get('id')));
            $em->flush();
            return new Response();
        }
    }

    public function getNewArticleAction()
    {
        // Ne gère pas exception page not found
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $request = $this->get('request');
            $url = $request->request->get('page');
            $tmp = explode('admin_',$url);
            $page = $this->get('doctrine')->getRepository('yomaahBundle:Page')->findOneBy(array('pageUrl' => $tmp[1]));
            $article = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findDefaultArticle($request->request->get('position'),$tmp[1], $page);
            return $this->container->get('templating')->renderResponse('YomaahajaxBundle:Ajax:layoutArticle.html.twig', array('article' => $article));
        }else if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $request = $this->get('request');
            $url = $request->request->get('page');
            $tmp = explode('test_',$url);
            $page = $this->get('doctrine')->getRepository('yomaahBundle:PageTest')->findOneBy(array('pageUrl' => $tmp[1]));
            $article = $this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')->findDefaultArticle($request->request->get('position'),$tmp[1], $page);
            return $this->container->get('templating')->renderResponse('YomaahajaxBundle:Ajax:layoutArticle.html.twig', array('article' => $article));
        }
    }


    public function getDialogAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $request = $this->get('request');
            $template = 'YomaahajaxBundle:Ajax:'.$request->request->get('dialog').'.html.twig';
            return $this->container->get('templating')->renderResponse($template);
        }
    }

    private function clearTitre($champ, $content)
    {
        if ($champ == 'art-titre')
        {
            if (preg_match('/<br>/',$content))
            {
                $tmp = explode('<br>',$content);
                return $tmp[0];
            }else
            {
                return $content;
            }
        }else
        {
            return $content;
        }
    }

    private function getSetterGetter($champ)
    {
        switch ($champ)
        {
        case 'art-titre':
            $retour['getter'] = 'getArtTitle';
            $retour['setter'] = 'setArtTitle';
            break;
        case 'art-content':
            $retour['getter']= 'getArtcontent';
            $retour['setter'] = 'setArtContent';
            break;
        default:
            $retour = false;
        }
        return $retour;
    }
}
