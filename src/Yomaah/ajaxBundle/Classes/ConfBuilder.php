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

    public function getInterfaceSrc()
    {
        return parent::getInterfaceSrc();
    }

    public function saveConf()
    {
        $this->saveXml();
    }

    public function getGeneralKeywords()
    {
        $keyword = $this->getByXpath('//keyword');
        if ((bool) $keyword)
        {
            return (string) $keyword[0];
        }
    }

    public function getByXpath($xpath)
    {
        $xml = $this->getConf();
        return $xml->xpath($xpath);
    }

    public function saveXml(\SimpleXmlElement $xml = null, $fullPath = null)
    {
        parent::saveFile($xml, $fullPath);
    }

    public function getXml($fullPath = null)
    {
        return parent::getFile($fullPath);
        
    }

    public function getTemplate($filename)
    {
        $path = $this->getBasePath().'Resources/views/TemplateAdmin/'.$filename.'.html.twig';
        $pathYomaah = $this->getSrcPath().'Yomaah/structureBundle/Resources/views/TemplateAdmin/'.$filename.'.html.twig';
        if ($this->fileExists($path))
        {
            return file_get_contents($path);
            
        }else if ($this->fileExists($pathYomaah))
        {
            return file_get_contents($pathYomaah);
        }else
        {
            return false;
        }
    }
    private function fileExists($path)
    {
        if (file_exists($path))
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function getSrcPath()
    {
        $tmp = preg_split('/src/', __DIR__);
        return $tmp[0].'src/';
        
    }
    private function getBasePath()
    {
        $tmp = preg_split('/src/', __DIR__);
        return $tmp[0].'src/'.$this->dispatcher->getSitePath().'/'.$this->dispatcher->getControllers().'/';
    }

    public function getScript($filename)
    {
        $path = $this->getBasePath().'Resources/public/js/AppendOnline/'.$filename.'.js';
        if ($this->FileExists($path))
        {
            //return '../../web/bundles/euroliteriestructure/js/AppendOnline/'.$filename.'.js';
            return file_get_contents($path);
            
        }else
        {
            return false;
        }
    }

}
