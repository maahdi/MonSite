<?php
namespace Yomaah\ajaxBundle\Classes;

class DisplayContent extends AbsElement
{
    private $_onglet;
    private $_content;
    private $_class = 'display';
    private $_balise = 'article';

    public function __construct($distinctClass = null, $title = null)
    {
        if ($distinctClass === null && $title === null)
        {
            $distinctClass = 'accueil';
            $title = 'Accueil';
            $message = new Element('h2', 'Bienvenue dans l\'interface de gestion');
            $input = new Element('input', null, null, array('value'  => 'accueil', 'type' => 'hidden'));
            $onglet = new Onglet($title, $distinctClass);
            $onglet->addElement($input);
            $ongletBar = new Element('section', $onglet , 'ongletBar');
            $content = new Element('section', $message , $distinctClass.' content');
            parent::__construct($this->_balise, array($ongletBar, $content), $this->_class);
        }
    }

    public function getNewForJson($distinctClass, $title, $id, AbsElement $element = null)
    {
        $input = new Element('input', null, null, array('value'  => $id, 'type' => 'hidden'));
        $onglet = new Onglet($title, $distinctClass);
        $onglet->addElement($input);
        $content = new Element('section', $element , $distinctClass.' content');
        return array('onglet' => $onglet->getHtml(), 'content' => $content->getHtml());
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}
