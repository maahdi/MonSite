<?php
namespace Yomaah\ajaxBundle\Classes;

class Image extends absElement
{
    private $_balise = 'img';
    private $attributes = array ('alt' => null, 'src' => null);

    public function __construct($src, $alt = null, $class = null)
    {
        $this->attributes['alt'] = $alt;
        $this->attributes['src'] = $src;
        parent::__construct($this->_balise, null, $class, $this->attributes);
    }
}
