<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity(repositoryClass="PageRepo")
 *@ORM\Table(name="page")
 */
class Page
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
     *@ORM\OneToMany(targetEntity="Article", mappedBy="page")
     */
    protected $articles;

    /**
     *@ORM\ManyToOne(targetEntity="Site",inversedBy="page")
     *@ORM\JoinColumn(name="idSite", referencedColumnName="idSite")
     **/
    protected $site;

    /**
     *@ORM\Column(type="text")
     */
    protected $keywords;

     /* Set pageId
     *
     * @param integer $site
     * @return Page
     */
    public function setSite($site)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get pageId
     *
     * @return integer 
     */
    public function getSite()
    {
        return $this->site;
    }
    /* Set pageId
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
     * Set keywords
     *
     * @param string $keywords
     * @return Page
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    
        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
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
        if (count($this->articles) > 0)
        {
            return $this->articles;
        }else
        {
            return null;
        }
    }
}
