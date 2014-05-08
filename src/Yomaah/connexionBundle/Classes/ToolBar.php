<?php
namespace Yomaah\connexionBundle\Classes;

class ToolBar extends AbsElement
{
    private $_class = 'toolBar';
    private $_name = 'article';

    public function __construct()
    {
        parent::__construct($this->_name, null, $this->_class);
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}
