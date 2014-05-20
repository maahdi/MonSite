<?php
namespace Yomaah\ajaxBundle\Classes;

use Yomaah\ajaxBundle\Classes\ConfBuilder;

class DisplayContent extends AbsElement
{
    private $_class = 'display';
    private $_balise = 'article';
    private $_content;
    private $_onglet;

    public function __construct(ConfBuilder $builder)
    {
        parent::__construct($this->_balise, null, $this->_class);
        $this->_content = new Element('section', null, 'content');
        $this->_conf = $builder;
    }

    public function setDefaultDisplay()
    {
        $distinctClass = 'accueil';
        $title = 'Accueil';
        $message = new Element('h2', 'Bienvenue dans l\'interface de gestion');
        $onglet = new Onglet($title,'accueil', $distinctClass);
        $ongletBar = new Element('section', $onglet , 'ongletBar');
        $this->_content->addElement($message);
        $this->_content->addClass($distinctClass);
        parent::replaceElement(array($ongletBar, $this->_content));
        return $this;
    }

    public function set($type, $distinctClass)
    {
        $imgSrc = $this->getByXpath('//srcImg');
        $tmpElem = null;
        $this->_content->addClass($distinctClass);
        if ((bool)($type = parent::getByXpath('//displayContent/type[@name="'.$type.'"]'))){
            foreach ($type[0]->containers->element as $element)
            {
                $tmpElem = new Element((string)$element->balise, null, (string) $element->class);
                if (isset($element->contains))
                {
                    $tmpElem = $this->parcoursElement($element->contains, $tmpElem, (string) $imgSrc[0]);
                    
                }
                $this->_content->addElement($tmpElem);
            }
            $this->addElement($this->_content);
        }
        return $this;
    }

    public function parcoursElement(\SimpleXmlElement $xml, AbsElement $oldElem, $imgSrc)
    {
        if (isset($xml->elements->element))
        {
            foreach($xml->elements->element as $element)
            {
                if (isset($element->text))
                {
                    $newElem = new Element((string) $element->balise, (string) $element->text, (string) $element->class);

                }else
                {
                    $newElem = new Element((string) $element->balise, null, (string) $element->class);
                } 
                if (isset($element->contains))
                {
                    $newElem = $this->parcoursElement($element->contains, $newElem, $imgSrc);
                }
                $oldElem->addElement($newElem);
            }
        }
        if (isset($xml->elements->button))
        {
            foreach($xml->elements->button as $button)
            {
                $src = (string) $button->img;
                $oldElem->addElement(new Element((string) $button->container,
                                        new Image($imgSrc.$src),
                                        $button->class));
            }
            
        }
        return $oldElem;
    }

    public function getDragDropContent($files)
    {
        if (is_array($files))
        {
            $figure = new Element('section', null , null);
            $checkbox = new Element('input', null, null, array('type' => 'checkbox', 'name' => 'active'));
            foreach ($files['active'] as $file)
            {
                $figure->addElement(new Element('figure',array(new Image($file), $checkbox), 'dragDrop-min-up'));
            }
            $checkbox = null;
            $checkbox = new Element('input', null, null, array('type' => 'checkbox', 'name' => 'inactive'));
            foreach ($files['inactive'] as $file)
            {
                $figure->addElement(new Element('figure',array(new Image($file), $checkbox), 'dragDrop-min-down'));
            }
        }
        return $figure->getHtml();
        
    }

    public function getHtml()
    {
        return parent::getHtml();
    }
}
