<?php
namespace Yomaah\ajaxBundle\Classes;

abstract class AbsElement
{
    
    protected $_conf;
    private $class;
    private $balise;
    private $element;
    private $attributes;

    public function __construct($name, $value, $class = null, $attributes = null)
    {
        $this->balise = $name;
        $this->class = $class;
        $this->attributes = $attributes;
        $this->element = $value;
    }

    protected function getByXpath($xpath)
    {
        if (isset($this->_conf))
        {
            $xml = $this->_conf->getInterfaceSrc();
            return $xml->xpath($xpath);
        }
    }

    public function addElement(AbsElement $element)
    {
        if (is_array($this->element))
        {
            $this->element[] = $element;
        }else if (is_object($this->element))
        {
            $tmp = $this->element;
            $this->element = array($tmp, $element);
        }else if ($this->element === null)
        {
            $this->element = $element;
        }
    }
    public function replaceElement($element)
    {
        $this->element = $element;
    }

    protected function endOfStructure()
    {
        switch ($this->balise)
        {
        case 'input':
        case 'img':
            return ' />';
            break;
        default :
            return false;
            break;
        }
    }
    public function addClass($class)
    {
        $this->class .= ' '.$class;
    }
    public function replaceClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        if ($this->class !== null)
        {
            return $this->class;
        }else
        {
            return false;
        }
    }

    private function constructStructure()
    {
        $structure = '<'.$this->balise.' ';
        if (($class = $this->getClass()) !== false)
        {
            $structure .= 'class="'.$class.'" ';
        }
        if (is_array($this->attributes))
        {
            foreach ($this->attributes as $key => $value)
            {
                if ($value !== true)
                {
                    $structure .= $key.'="'.$value.'"';
                }else
                {
                    $structure .= $key;
                }
            }
        }
        if ($this->endOfStructure() !== false)
        {
            $structure .= $this->endOfStructure();

        }else if ($this->element !== null && gettype($this->element) !== 'object'

                && is_array($this->element) === false)
        {
            $structure .= ' >'.$this->element.'</'.$this->balise.'>';

        }else if ($this->element === null)
        {
            $structure .= ' ></'.$this->balise.'>';
        
        }else if (gettype($this->element) === 'object')
        {
            $structure .= ' >'.$this->element->getHtml().'</'.$this->balise.'>';
        }else if (is_array($this->element))
        {
            $structure .= '> ';
            foreach ($this->element as $value)
            {
                if (gettype($value) === 'object')
                {
                    $structure .= $value->getHtml();
                }else
                {
                    $structure .= $value;
                }
            }
            $structure .= '</'.$this->balise.'>';
        }

        return $structure;
    }

    public function getHtml()
    {
        return $this->constructStructure();
    }

    public function getAttributes($name)
    {
        if (is_array($this->attributes))
        {
            if (array_key_exists($name, $this->attributes))
            {
                return $this->attributes[$name];
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }
    }

    public function setAttributes($name, $value)
    {
        if (is_array($this->attributes))
        {
            $this->attributes[$name] = $value;
            
        }else if ($this->attributes === null)
        {
            $this->attributes = array($name => $value);
        }
    }
}
