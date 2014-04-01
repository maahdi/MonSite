<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity(repositoryClass="SiteRepo")
 *@ORM\Table(name="site")
 */
class Site
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idSite;

    /**
     *@ORM\Column(type="string")
     */
    protected $nomSite;
    /**
     *@ORM\Column(type="string")
     */
    protected $tag;

    /**
     *@ORM\ManyToOne(targetEntity="\Yomaah\connexionBundle\Entity\User",inversedBy="sites")
     *@ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     **/
    protected $user;

    /**
     *@ORM\OneToMany(targetEntity="Page", mappedBy="site")
     */
    protected $page;

    /**
     * Add page
     *
     * @param \Yomaah\structureBundle\Entity\Page $page
     * @return Page
     */
    public function addPage(\Yomaah\structureBundle\Entity\Page $page)
    {
        $this->page[] = $page;
    
        return $this;
    }

    /**
     * Remove page
     *
     * @param \Yomaah\structureBundle\Entity\Page $page
     */
    public function removePage(\Yomaah\structureBundle\Entity\Page $page)
    {
        $this->page->removeElement($page);
    }

    /**
     * Get page
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set idSite
     *
     * @param string $idSite
     * @return Site
     */
    public function setIdSite($idSite)
    {
        $this->idSite = $idSite;
    
        return $this;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Site
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }
    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }
    /**
     * Get idSite
     *
     * @return string 
     */
    public function getIdSite()
    {
        return $this->idSite;
    }

    /**
     * Set nomSite
     *
     * @param string $nomSite
     * @return Site
     */
    public function setNomSite($nomSite)
    {
        $this->nomSite = $nomSite;
    
        return $this;
    }

    /**
     * Get nomSite
     *
     * @return string 
     */
    public function getNomSite()
    {
        return $this->nomSite;
    }

    /**
     * Set User
     *
     * @param \Yomaah\connexionBundle\Entity\User $User
     * @return Site
     */
    public function setUser(\Yomaah\connexionBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get User
     *
     * @return \Yomaah\connexionBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
