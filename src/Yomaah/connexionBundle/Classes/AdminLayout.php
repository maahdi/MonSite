<?php
namespace Yomaah\connexionBundle\Classes;

class AdminLayout
{
    private $navBar;
    private $toolBar;
    private $displayContent;
    private $class = 'AdminPanel';

    public function __construct(NavBar $navBar, ToolBar $toolBar, DisplayContent $displayContent)
    {
        $this->navBar = $navBar;
        $this->toolBar = $toolBar;
        $this->displayContent = $displayContent;
    }

    public function getHtml()
    {
        return '<article class="'.$this->class.'">'.$this->navBar->getHtml().$this->toolBar->getHtml().$this->displayContent->getHtml().'</article>';
    }

    public function addElement($name, AbsElement $element)
    {

        if ($this->testElementType($element, $name))
        {
            $this->$name->addElement($element);
            return true;

        }else
        {
            return false;
        }
    }

    private function testElement($name)
    {
        switch ($name)
        {
        case 'navBar':
        case 'toolBar':
        case 'displayContent':
            return true;
            break;
        default:
            return false;
            break;
        }
    }

    public function testElementType(AbsElement $element, $name = null)
    {
        if ($name === null)
        {
            switch (get_class($element))
            {
            case 'NavBar':
            case 'ToolBar':
            case 'DisplayContent':
                return true;
                break;
            default:
                return false;
                break;
            }
        }else
        {
            if ($this->testElement($name))
            {
                if (ucfirst($name) === get_class($element))
                {
                    return true;
                }else
                {
                    return false;
                }
            }else
            {
                return false;
            }
        }
        
    }

    public function replaceElement($name, AbsLayout $element)
    {
        if ($this->testElementType($element, $name))
        {
            $this->$name = $element;
        }
        
    }
}
