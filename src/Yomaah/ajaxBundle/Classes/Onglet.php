<?php
namespace Yomaah\ajaxBundle\Classes;

class Onglet extends AbsElement
{
    private $_class = 'onglet';
    private $_name = 'section';

    public function __construct($titre, $id)
    {
        $close = new Element('figure', new Image('../../bundles/yomaah/images/admin/fermer.png'), 'close');
        $titre = new Element('h1', $titre);
        parent::__construct($this->_name, array($titre, $close), $this->_class, array('id' => $id));
    }
    public function addElement(AbsElement $element)
    {
        parent::addElement($element);
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}