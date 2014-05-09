<?php
namespace Yomaah\ajaxBundle\Classes;

class NavBar extends AbsElement
{
    
    public function __construct($elements)
    {
        parent::__construct('article', $elements, 'navBar');
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}
