<?php
namespace Yomaah\ajaxBundle\Classes;

class ToolBar extends AbsElement
{
    private $_class = 'toolBar';
    private $_name = 'article';

    public function __construct($element = null)
    {
        parent::__construct($this->_name, $element, $this->_class);
    }

    public function replaceElement($element)
    {
        parent::replaceElement($element);
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
