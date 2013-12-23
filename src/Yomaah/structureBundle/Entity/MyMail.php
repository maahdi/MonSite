<?php
namespace Yomaah\structureBundle\Entity;



class MyMail
{
    private $de;
    private $objet;
    private $message;
    public function __construct()
    {
    }

    public function getDe()
    {
        return $this->de;
    }
    public function setDe($de)
    {
        $this->de = $de;
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
        $mailer->setFrom('moi@lol.fr');
        return $mailer;
    }
}
