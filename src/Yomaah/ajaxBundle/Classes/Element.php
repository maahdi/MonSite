<?php
namespace Yomaah\ajaxBundle\Classes;

class Element extends AbsElement 
{
    public function __construct($name, $content, $class = null, $attributs = null)
    {
        parent::__construct($name, $content, $class, $attributs);
    }

    public function getHtml()
    {
        return parent::getHtml();
    }

    public function getAttributes($name)
    {
        return parent::getAttributes($name);
    }

    public function setAttributes($name, $value)
    {
        parent::setAttributes($name, $value);
    }
    
    public function replaceElement($element)
    {
        parent::replaceElement($element);
    }

    public function addElement(AbsElement $element)
    {
        parent::addElement($element);
    }
}
