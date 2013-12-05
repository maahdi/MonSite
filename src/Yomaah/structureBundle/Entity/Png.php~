<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\CollectionsArrayCollection;

/**
 *@ORM\Entity(repositoryClass="PngRepo")
 *@ORM\Table(name="png")
 */
class Png
{
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $pngId;

    /**
     *@ORM\Column(type="string")
     */
    protected $pngUrl;

    /**
     *@ORM\Column(type="string")
     */
    protected $pngCategory;

    /**
     *@ORM\OneToMany(targetEntity="Article", mappedBy="png")
     */
    protected $articles;

    /**
     * Set pngId
     *
     * @param integer $pngId
     * @return Png
     */
    public function setPngId($pngId)
    {
        $this->pngId = $pngId;
    
        return $this;
    }

    /**
     * Get pngId
     *
     * @return integer 
     */
    public function getPngId()
    {
        return $this->pngId;
    }

    /**
     * Set pngUrl
     *
     * @param string $pngUrl
     * @return Png
     */
    public function setPngUrl($pngUrl)
    {
        $this->pngUrl = $pngUrl;
    
        return $this;
    }

    /**
     * Get pngUrl
     *
     * @return string 
     */
    public function getPngUrl()
    {
        return $this->pngUrl;
    }

    /**
     * Set pngCategory
     *
     * @param string $pngCategory
     * @return Png
     */
    public function setPngCategory($pngCategory)
    {
        $this->pngCategory = $pngCategory;
    
        return $this;
    }

    /**
     * Get pngCategory
     *
     * @return string 
     */
    public function getPngCategory()
    {
        return $this->pngCategory;
    }

    /**
     * Add articles
     *
     * @param \Yomaah\structureBundle\Entity\Article $articles
     * @return Png
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