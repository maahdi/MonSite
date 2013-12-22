<?php
namespace Yomaah\connexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 *@ORM\Entity
 *@ORM\Table(name="groupes")
 **/
class Group implements RoleInterface
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idGroup;

    /**
     *@ORM\Column(type="string")
     **/
    protected $nomGroupe;

    /**
     *@ORM\OneToMany(targetEntity="User", mappedBy="group")
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getRole()
    {
        return $this->nomGroupe;
    }

    /**
     * Set idGroup
     *
     * @param integer $idGroup
     * @return Group
     */
    public function setIdGroup($idGroup)
    {
        $this->idGroup = $idGroup;
    
        return $this;
    }

    /**
     * Get idGroup
     *
     * @return integer 
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }

    /**
     * Set nomGroupe
     *
     * @param string $nomGroupe
     * @return Group
     */
    public function setNomGroupe($nomGroupe)
    {
        $this->nomGroupe = $nomGroupe;
    
        return $this;
    }

    /**
     * Get nomGroupe
     *
     * @return string 
     */
    public function getNomGroupe()
    {
        return $this->nomGroupe;
    }

    /**
     * Add users
     *
     * @param \Yomaah\connexionBundle\Entity\User $users
     * @return Group
     */
    public function addUser(\Yomaah\connexionBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Yomaah\connexionBundle\Entity\User $users
     */
    public function removeUser(\Yomaah\connexionBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}