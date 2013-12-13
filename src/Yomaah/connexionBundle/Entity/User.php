<?php
namespace Yomaah\connexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *@ORM\Entity
 *@ORM\Table(name="utilisateurs")
 **/
class User implements AdvancedUserInterface
{

    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $id;


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

    public function getRoles()
    {
        return array($this->group->getRole());
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
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
    public function equals(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
    

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
}
