<?php
namespace Yomaah\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 *@ORM\Entity(repositoryClass="AdresseRepo")
 *@ORM\Table(name="adresse")
 */
class Adresse implements \JsonSerializable
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idAdresse;

    /**
     *@ORM\Column(type="string")
     */
    protected $voie;

    /**
     *@ORM\Column(type="string")
     */
    protected $voieSuite;

    /**
     *@ORM\Column(type="integer")
     */
    protected $cp;

    /**
     *@ORM\Column(type="string")
     */
    protected $ville;

    /**
     *@ORM\Column(type="string")
     */
    protected $tag;

    /**
     *@ORM\Column(type="string")
     */
    protected $telephone;

    /**
     *@ORM\ManyToOne(targetEntity="Yomaah\connexionBundle\Entity\User",inversedBy="idAdresse")
     *@ORM\JoinColumn(name="adresse", referencedColumnName="idAdresse")
     **/
    protected $utilisateur;
    public function jsonSerialize()
    {
        return array();
    }

    /**
     * Set idAdresse
     *
     * @param integer $idAdresse
     * @return Adresse
     */
    public function setIdAdresse($idAdresse)
    {
        $this->idAdresse = $idAdresse;
    
        return $this;
    }

    /**
     * Get idAdresse
     *
     * @return integer 
     */
    public function getIdAdresse()
    {
        return $this->idAdresse;
    }

    /**
     * Set voie
     *
     * @param string $voie
     * @return Adresse
     */
    public function setVoie($voie)
    {
        $this->voie = $voie;
    
        return $this;
    }

    /**
     * Get voie
     *
     * @return string 
     */
    public function getVoie()
    {
        return $this->voie;
    }

    /**
     * Set voieSuite
     *
     * @param string $voieSuite
     * @return Adresse
     */
    public function setVoieSuite($voieSuite)
    {
        $this->voieSuite = $voieSuite;
    
        return $this;
    }

    /**
     * Get voieSuite
     *
     * @return string 
     */
    public function getVoieSuite()
    {
        return $this->voieSuite;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     * @return Adresse
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    
        return $this;
    }

    /**
     * Get cp
     *
     * @return integer 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Adresse
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
     * Set telephone
     *
     * @param string $telephone
     * @return Adresse
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set utilisateur
     *
     * @param \Yomaah\connexionBundle\Entity\User $utilisateur
     * @return Adresse
     */
    public function setUtilisateur(\Yomaah\connexionBundle\Entity\User $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;
    
        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Yomaah\connexionBundle\Entity\User 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
