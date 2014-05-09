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
            $onglet = new Element('section', new Onglet($title, $distinctClass), 'ongletBar');
            $content = new Element('section', $message , $distinctClass.' content');
            parent::__construct($this->_balise, array($onglet, $content), $this->_class);
        }
    }

    public function getNewForJson($distinctClass, $title, AbsElement $element)
    {
        $onglet = new Onglet($title, $distinctClass);
        $content = new Element('section', $element , $distinctClass.' content');
        return array('onglet' => $onglet, 'content' => $content);
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}
