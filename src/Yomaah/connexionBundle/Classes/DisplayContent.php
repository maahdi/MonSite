<?php
namespace Yomaah\connexionBundle\Classes;

class DisplayContent extends DctElement
{
    private $_onglet;

    /*
     * $display = new DisplayContent(new Element('article', null, 'displayContent'));
     */
    public function __construct(AbsElement $element, $distinctClass, Onglet $onglet = null)
    {
        $regex = '/'.$distinctClass.'/';

        if (preg_match($regex, $element->getClass()) === 0)
        $element->addClass($element->getClass().','.$distinctClass);

        parent::__construct($element);
        /*
         * onglet par défaut pour le premier appel
         * ensuite mettre le bon onglet correspondant seul
         * new Onglet('Foo', $distinctClass);
         * une fonction ajax le placera dans la barre ongletContent
         */
        if ($onglet === null)
        {
            $this->_onglet = new Element('article', new Onglet('Accueil', $distinctClass), 'ongletContent');
        }else
        {
            if (($id = $onglet->getAttributes('id')) !== false)
            {
                if ($id != $distinctClass)
                {
                    $onglet->setAttributes('id', $distinctClass);
                }
            }
            $this->_onglet = $onglet;
        }
    }

    public function replaceOnglet(AbsElement $onglet)
    {
        $this->_onglet = $onglet;
    }

    public function getHtml()
    {
        return $this->_onglet->getHtml().parent::getHtml();
    }
}
