<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity(repositoryClass="PageTestRepo")
 *@ORM\Table(name="pageTest")
 */
class PageTest
{
    public function __construct()
    {
       $this->articles = new ArrayCollection(); 
    }
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $pageId;

    /**
     *@ORM\Column(type="string")
     */
    protected $pageUrl;

    /**
     *@ORM\OneToMany(targetEntity="ArticleTest", mappedBy="page")
     */
    protected $articles;

    /**
     *@ORM\Column(type="integer")
     */
    protected $token;

    /**
     * Set token
     *
     * @param int $path
     * @return Menu
     */
    public function setToken($path)
    {
        $this->token = $path;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return int 
     */
    public function getToken()
    {
        return $this->Token;
    }
    /**
     * Set pageId
     *
     * @param integer $pageId
     * @return Page
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    
        return $this;
    }

    /**
     * Get pageId
     *
     * @return integer 
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * Set pageUrl
     *
     * @param string $pageUrl
     * @return Page
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;
    
        return $this;
    }

    /**
     * Get pageUrl
     *
     * @return string 
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Add articles
     *
     * @param \Yomaah\structureBundle\Entity\Article $articles
     * @return Page
     */
    public function addArticle(\Yomaah\structureBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;
    
        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Yomaah\structureBundle\Entity\Article $articles
     */
    public function removeArticle(\Yomaah\structureBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
