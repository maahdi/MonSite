<?php
namespace Yomaah\connexionBundle\Classes;

abstract class DctElement extends AbsElement 
{
    private $element;

    public function __construct(AbsElement $element)
    {
        $this->element = $element;
    }

    public function getHtml()
    {
        return $this->element->getHtml();
    }
    
}
