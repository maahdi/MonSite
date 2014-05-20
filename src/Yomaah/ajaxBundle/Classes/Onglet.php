<?php
namespace Yomaah\ajaxBundle\Classes;

class Onglet extends AbsElement
{
    private $_class = 'onglet';
    private $_name = 'section';

    public function __construct($titre, $id, $distinctClass)
    {
        $close = new Element('figure', new Image('../../bundles/yomaah/images/admin/fermer.png'), 'close');
        $input = new Element('input', null, null, array('value'  => $id, 'type' => 'hidden'));
        $titre = new Element('h1', $titre);
        parent::__construct($this->_name, array($titre, $close, $input), $this->_class, array('id' => $distinctClass));
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
