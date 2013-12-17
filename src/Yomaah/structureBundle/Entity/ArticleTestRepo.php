<?php

namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Yomaah\structureBundle\Entity\PageTest;

/**
 * articleRepo
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleTestRepo extends EntityRepository
{
    public function findByPage($pageUrl)
    {
        $query = $this->getEntityManager()->createQuery('select a, p from yomaahBundle:ArticleTest a join a.page p where p.pageUrl = :url order by a.artId asc')->setParameter('url',$pageUrl);
        return $query->getResult();
    }

    public function findDefaultArticle($position, $pageUrl, \Yomaah\structureBundle\Entity\PageTest $page)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select a from yomaahBundle:ArticleTest a join a.page p where p.pageUrl = \'default\'');
        $article = $query->getSingleResult();
        $new = new ArticleTest();
        $new->setArtTitle($article->getArtTitle());
        $new->setArtContent($article->getArtContent());
        $new->setArtDate(new \Datetime());
        $new->setPng($article->getPng());
        $new->setPage($page);
        $new->setArtId($this->getNewId($position, $pageUrl, $em));
        $em->persist($new);
        $em->flush();
        return $new;
    }

    public function getNewId($position, $pageUrl, $em)
    {
        $query = $em->createQuery('select max(a.artId) from yomaahBundle:ArticleTest a');
        $id = $query->getSingleResult(); 
        $maxId = (int) $id[1] + 1;

        if ($position == "0")
        {
            $query = $em->createQuery('select a from yomaahBundle:ArticleTest a join a.page p where p.pageUrl = :url order by a.artId asc')
                        ->setParameter('url',$pageUrl);
            $articles = $query->getResult();
            if (!(count($articles) == 0))
            {
                $nb = count($articles);
                $minId = $articles[0]->getArtId();
                $lastId = null;
                for ($i = 0; $i < $nb;$i++)
                {
                    if ($i != $nb - 1)
                    {
                        $this->changeId($articles[$i],$articles[$i+1]);
                    }else
                    {
                        $articles[$i]->setArtId($maxId);
                    }
                }
                $j = $nb - 1;
                for ($i = 0; $i < $nb; $i++)
                {
                    $em->createQuery('update yomaahBundle:ArticleTest a set a.artId = :artId where a.id = :id')
                        ->setParameters(array('artId' => $articles[$j]->getArtId(),'id' => $articles[$j]->getId()))
                        ->execute();
                    $j--;
                }
                return $minId;
            }else
            {
                return $maxId;
                
            }
        }else
        {
            return $maxId;
        }
    }

    private function changeId($first, $second)
    {

        $first->setArtId($second->getArtId());
    }
}