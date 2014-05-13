<?php
namespace Yomaah\ajaxBundle\Classes;
use Yomaah\structureBundle\Classes\BundleDispatcher;

class ConfBuilder extends MyXml
{
    private $dispatcher;
    public function __construct(BundleDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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
    public function getTemplate($filename)
    {
        $tmp = preg_split('/src/', __DIR__);
        $basePath = $tmp[0].'src/'.$this->dispatcher->getSitePath().'/'.$this->dispatcher->getControllers();
        $path = $basePath.'/Resources/views/TemplateAdmin/'.$filename.'.html.twig';
        if (file_exists($path))
        {
            return file_get_contents($path);
            
        }else
        {
            return false;
        }
    }

}
