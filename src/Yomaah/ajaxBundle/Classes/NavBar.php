<?php
namespace Yomaah\ajaxBundle\Classes;

class NavBar extends AbsElement
{
    
    public function __construct()
    {
        parent::__construct('article', null, 'navBar');
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
    public function addElement(AbsElement $element)
    {
        parent::addElement($element);
    }
    public function replaceElement($element)
    {
        parent::replaceElement($element);
    }
}
