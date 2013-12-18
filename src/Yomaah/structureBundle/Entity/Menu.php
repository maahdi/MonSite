<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    protected $id;

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
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
