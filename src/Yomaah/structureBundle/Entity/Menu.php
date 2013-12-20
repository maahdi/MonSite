<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity(repositoryClass="MenuRepo")
 *@ORM\Table(name="menu")
 */
class Menu
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idMenu;

    /**
     *@ORM\Column(type="string")
     */
    protected $path;

    /**
     *@ORM\Column(type="string")
     */
    protected $name;

    /**
     *@ORM\Column(type="integer")
     */
    protected $position;

    /**
     *@ORM\Column(type="integer")
     */
    protected $site;
    
    /**
     *@ORM\OneToMany(targetEntity="SousMenu", mappedBy="menu")
     */
    protected $sousMenu;

    /**
     * Add sousMenu
     *
     * @param \Yomaah\connexionBundle\Entity\User $sousMenu
     * @return Group
     */
    public function addSousMenu(\Yomaah\structureBundle\Entity\SousMenu $sousMenu)
    {
        $this->sousMenu[] = $sousMenu;
    
        return $this;
    }

    /**
     * Remove sousMenu
     *
     * @param \Yomaah\connexionBundle\Entity\User $sousMenu
     */
    public function removeSousMenu(\Yomaah\structureBundle\Entity\SousMenu $sousMenu)
    {
        $this->sousMenu->removeElement($sousMenu);
    }

    /**
     * Get sousMenu
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSousMenu()
    {
        return $this->sousMenu;
    }

    public function __construct()
    {
        $this->sousMenu = new ArrayCollection();
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Menu
     */
    public function setSite($site)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }
    /**
     * Set path
     *
     * @param string $path
     * @return Menu
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Menu
     */
    public function setIdMenu($id)
    {
        $this->idMenu = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }
}
