<?php
namespace Yomaah\connexionBundle\Classes;

class Onglet extends AbsElement
{
    private $_class = 'onglet';
    private $_name = 'section';

    public function __construct($titre, $id)
    {
        $close = new Element('figure', new Element('img' , null, null, array('src' => 'images/ici.png')), 'close');
        $titre = new Element('h1', $titre);
        parent::__construct($this->_name, array($titre, $close), $this->_class, array('id' => $id));
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}
