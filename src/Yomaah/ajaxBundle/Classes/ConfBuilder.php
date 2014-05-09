<?php
namespace Yomaah\ajaxBundle\Classes;
use Yomaah\structureBundle\Classes\BundleDispatcher;

class ConfBuilder extends MyXml
{
    public function __construct(BundleDispatcher $dispatcher)
    {
        $tmp = preg_split('/Yomaah/', __DIR__);
        $path = $tmp[0].$dispatcher->getSitePath().'/'.$dispatcher->getControllers().'/XML/'.$dispatcher->getSite().'.xml';
        parent::__construct($path);
    }

    public function getConf()
    {
        return parent::getFile();
    }

    public function saveConf()
    {
        $this->saveXml($xml);
    }

    public function getByXpath($xpath)
    {
        $xml = $this->getConf();
        return $xml->xpath($xpath);
    }

    public function saveXml(\SimpleXmlElement $xml, $file = null)
    {
        parent::saveFile($xml, $file);
    }

    public function getXml($file = null)
    {
        return parent::getFile($file);
        
    }

    public function getNavBar()
    {
        
    }

    public function getToolBar()
    {
        
    }
    public function getDisplayContent()
    {
        
    }

    public function getDialog()
    {
        
    }
}
