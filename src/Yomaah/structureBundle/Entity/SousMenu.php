<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity()
 *@ORM\Table(name="sousMenu")
 **/
class SousMenu
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idSousMenu;

    /**
     *@ORM\Column(type="string")
     */
    protected $path;

    /**
     *@ORM\Column(type="string")
     */
    protected $name;

    /**
     *@ORM\ManyToOne(targetEntity="Menu",inversedBy="sousMenu")
     *@ORM\JoinColumn(name="idMenu", referencedColumnName="idMenu")
     **/
    protected $menu;
    

    /**
     * Set idSousMenu
     *
     * @param integer $idSousMenu
     * @return SousMenu
     */
    public function setIdSousMenu($idSousMenu)
    {
        $this->idSousMenu = $idSousMenu;
    
        return $this;
    }

    /**
     * Get idSousMenu
     *
     * @return integer 
     */
    public function getIdSousMenu()
    {
        return $this->idSousMenu;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return SousMenu
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
     * @return SousMenu
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
     * Set menu
     *
     * @param \Yomaah\structureBundle\Entity\Menu $menu
     * @return SousMenu
     */
    public function setMenu(\Yomaah\structureBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;
    
        return $this;
    }

    /**
     * Get menu
     *
     * @return \Yomaah\structureBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
