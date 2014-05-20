<?php
namespace Yomaah\ajaxBundle\Classes;

class Button extends AbsElement
{
    private $_class = 'modifPanel-btn';
    private $_balise = 'article';

    public function __construct($class, $text)
    {
        parent::__construct($this->_balise, $text, $this->_class.' '.$class);
    }
    public function getHtml()
    {
        return parent::getHtml();
    }
    
}
