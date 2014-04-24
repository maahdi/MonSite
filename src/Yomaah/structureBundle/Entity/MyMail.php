<?php
namespace Yomaah\structureBundle\Entity;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;
class MyMail
{
    
    private $from;
    private $objet;
    private $message;
    public function __construct()
    {
    }

    public function getFrom()
    {
        return $this->from;
    }
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function getObjet()
    {
        return $this->objet;
    }
    public function setObjet($objet)
    {
        $this->objet = $objet;
        return $this;
    }
    public function getSwiftMailer()
    {
        $mailer = \Swift_Message::newInstance();
        $mailer->setSubject($this->objet);
        $mailer->setBody($this->message);
        $mailer->setTo('kokoriko-yoshi@hotmail.fr');
        $mailer->setFrom($this->from);
        return $mailer;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('from', new Regex(array(
            'pattern' => '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,4}$/',
            'message' => 'L\'adresse mail n\'est pas valide !'
        )));
    }
}
