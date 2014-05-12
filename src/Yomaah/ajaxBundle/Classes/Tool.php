<?php
namespace Yomaah\ajaxBundle\Classes;

class Tool extends AbsElement
{
    private $_class = 'toolBar-btn';
    private $_balise = 'section';
    private $type = array('add-btn' => 'add.png',
        'att-btn' => 'refresh.png');

    public function __construct($type)
    {
        if (array_key_exists($type, $this->type))
        {
            $src = '../../bundles/yomaah/images/admin/'.$this->type[$type];
            parent::__construct($this->_balise, new Image($src), $this->_class.' '.$type);
        }
    }
}
