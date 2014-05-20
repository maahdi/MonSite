<?php
namespace Yomaah\ajaxBundle\Classes;

class ToolBar extends AbsElement
{
    private $_class = 'toolBar';
    private $_balise = 'article';

    public function __construct(ConfBuilder $builder, $element = null)
    {
        parent::__construct($this->_balise, $element, $this->_class);
        $this->_conf = $builder;
    }

    public function replaceElement($element)
    {
        parent::replaceElement($element);
    }


    public function set($toolname, $class)
    {
        $tmpsrc = parent::getByXpath('//srcImg');
        $imgSrc = (string) $tmpsrc[0];
        parent::addClass($class);
        if (is_array($toolname))
        {
            foreach($toolname as $name)
            {
                $tools = parent::getByXpath('//toolBar/class');
                $class = (string) $tools[0];
                $tmpButton = parent::getByXpath('//toolBar/button[@name="'.$name.'"]');
                if ((bool) $tmpButton[0])
                {
                    $balise = parent::getByXpath('//toolBar/button[@name="'.$name.'"]/container');
                    $src = parent::getByXpath('//toolBar/button[@name="'.$name.'"]/img');
                    $tmpsrc = (string) $src[0]; 
                    $this->addElement(new Tool((string) $balise[0], $imgSrc.$tmpsrc, $name.' '.$class));
                }
            }
        }
        return $this;
    }

    public function addElement(AbsElement $element)
    {
        parent::addElement($element);
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
    public function getNewToolBar($name)
    {
        if (is_array($name)){
            foreach($name as $value)
            {
                $this->addElement(new Tool($value));
            }
        }else{
                $this->addElement(new Tool($name));
        }
        return $this;
    }
}
