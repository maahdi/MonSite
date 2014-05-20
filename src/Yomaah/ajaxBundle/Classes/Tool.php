<?php
namespace Yomaah\ajaxBundle\Classes;

class Tool extends AbsElement
{
    public function __construct($balise, $src, $class)
    {
        parent::__construct($balise, new Image($src), $class);
    }
}
