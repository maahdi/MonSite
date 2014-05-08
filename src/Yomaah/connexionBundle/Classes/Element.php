<?php
namespace Yomaah\connexionBundle\Classes;

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
    
}
