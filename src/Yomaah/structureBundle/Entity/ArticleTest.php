<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity(repositoryClass="ArticleTestRepo")
 *@ORM\Table(name="articleTest")
 */
class ArticleTest
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     *@ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *@ORM\Column(type="integer", unique=true)
     */
    protected $artId;

    /**
     *@ORM\Column(type="date")
     */
    protected $artDate;

    /**
     *@ORM\Column(type="string")
     */
    protected $artTitle;

    /**
     *@ORM\Column(type="text")
     */
    protected $artContent;

    /**
     *@ORM\Column(type="string")
     */
    protected $artSource;

    /**
     *@ORM\Column(type="string")
     */
    protected $artLien;

    /**
     *@ORM\Column(type="string")
     */
    protected $artImgUrl;

//Champ clé étrangère
    /**
     *@ORM\ManyToOne(targetEntity="PageTest",inversedBy="articles",cascade="persist")
     *@ORM\JoinColumn(name="artPageId", referencedColumnName="pageId")
     */
    protected $page;

    /**
     *@ORM\ManyToOne(targetEntity="Png",inversedBy="articles")
     *@ORM\JoinColumn(name="artPngId", referencedColumnName="pngId")
     */
    protected $png;

    /**
     * Set artId
     *
     * @param integer $artId
     * @return Article
     */
    public function setArtId($artId)
    {
        $this->artId = $artId;
    
        return $this;
    }

    /**
     * Get artId
     *
     * @return integer 
     */
    public function getArtId()
    {
        return $this->artId;
    }

    /**
     * Set artDate
     *
     * @param \DateTime $artDate
     * @return Article
     */
    public function setArtDate($artDate)
    {
        $this->artDate = $artDate;
    
        return $this;
    }

    /**
     * Get artDate
     *
     * @return \string 
     */
    public function getArtDate()
    {
        return $this->artDate->format('d M Y');
    }

    /**
     * Set artContent
     *
     * @param string $artContent
     * @return Article
     */
    public function setArtContent($artContent)
    {
        $this->artContent = $artContent;
    
        return $this;
    }

    /**
     * Get artContent
     *
     * @return string 
     */
    public function getArtContent()
    {
        return $this->artContent;
    }

    /**
     * Set artSource
     *
     * @param string $artSource
     * @return Article
     */
    public function setArtSource($artSource)
    {
        $this->artSource = $artSource;
    
        return $this;
    }

    /**
     * Get artSource
     *
     * @return string 
     */
    public function getArtSource()
    {
        return $this->artSource;
    }

    /**
     * Set artLien
     *
     * @param string $artLien
     * @return Article
     */
    public function setArtLien($artLien)
    {
        $this->artLien = $artLien;
    
        return $this;
    }

    /**
     * Get artLien
     *
     * @return string 
     */
    public function getArtLien()
    {
        return $this->artLien;
    }

    /**
     * Set artImgUrl
     *
     * @param string $artImgUrl
     * @return Article
     */
    public function setArtImgUrl($artImgUrl)
    {
        $this->artImgUrl = $artImgUrl;
    
        return $this;
    }

    /**
     * Get artImgUrl
     *
     * @return string 
     */
    public function getArtImgUrl()
    {
        return $this->artImgUrl;
    }

    /**
     * Set page
     *
     * @param \Yomaah\structureBundle\Entity\PageTest $page
     * @return Article
     */
    public function setPage(\Yomaah\structureBundle\Entity\PageTest $page = null)
    {
        $this->page = $page;
    
        return $this;
    }

    /**
     * Get page
     *
     * @return \Yomaah\structureBundle\Entity\PageTest 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set png
     *
     * @param \Yomaah\structureBundle\Entity\Png $png
     * @return Article
     */
    public function setPng(\Yomaah\structureBundle\Entity\Png $png = null)
    {
        $this->png = $png;
    
        return $this;
    }

    /**
     * Get png
     *
     * @return \Yomaah\structureBundle\Entity\Png 
     */
    public function getPng()
    {
        return $this->png;
    }

    /**
     * Set artTitle
     *
     * @param string $artTitle
     * @return Article
     */
    public function setArtTitle($artTitle)
    {
        $this->artTitle = $artTitle;
    
        return $this;
    }

    /**
     * Get artTitle
     *
     * @return string 
     */
    public function getArtTitle()
    {
        return $this->artTitle;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
