<?php
namespace Yomaah\connexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity
 *@ORM\Table(name="utilisateur")
 **/
class User implements AdvancedUserInterface, \Serializable
{

    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idUser;


    /**
     *@ORM\Column(type="string")
     **/
    protected $login;

    /**
     *@ORM\Column(type="string")
     **/
    protected $password;

    /**
     *@ORM\ManyToOne(targetEntity="Group",inversedBy="users")
     *@ORM\JoinColumn(name="idGroup", referencedColumnName="idGroup")
     **/
    protected $group;

    /**
     *@ORM\OneToMany(targetEntity="\Yomaah\structureBundle\Entity\Site", mappedBy="user")
     */
    protected $sites;
    protected $salt;

    /**
     * Add sites
     *
     * @param \Yomaah\structureBundle\Entity\Site $site
     * @return User
     */
    public function addSite(\Yomaah\structureBundle\Entity\Site $site)
    {
        $this->sites[] = $site;
    
        return $this;
    }

    /**
     * Remove sites
     *
     * @param \Yomaah\connexionBundle\Entity\Site $sites
     */
    public function removeSite(\Yomaah\structureBundle\Entity\Site $site)
    {
        $this->users->removeElement($site);
    }

    /**
     * Get sites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSites()
    {
        return $this->sites;
    }

    public function __construct()
    {
        $this->sites = new ArrayCollection();
    }

    public function getRoles()
    {
        return array($this->group->getRole());
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt(){
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true; 
    }

    public function isAccountNonLocked()
    {
        return true;
        
    }

    public function isCredentialsNonExpired()
    {
        return true;
        
    }
    public function isEnabled()
    {
        return true;
    }
    //public function equals(UserInterface $user)
    //{
        //if (!$user instanceof WebserviceUser) {
            //return false;
        //}

        //if ($this->password !== $user->getPassword()) {
            //return false;
        //}

        //if ($this->getSalt() !== $user->getSalt()) {
            //return false;
        //}

        //if ($this->username !== $user->getUsername()) {
            //return false;
        //}

        //return true;
    //}
    

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set group
     *
     * @param \Yomaah\connexionBundle\Entity\Group $group
     * @return User
     */
    public function setGroup(\Yomaah\connexionBundle\Entity\Group $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \Yomaah\connexionBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set id
     *
     * @param integer $idUser
     * @return User
     */
    public function setIdUser($id)
    {
        $this->idUser = $id;
    
        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->idUser,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->idUser,
        ) = unserialize($serialized);
    }

}
