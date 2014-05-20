<?php
namespace Yomaah\ajaxBundle\Classes;

abstract class MyXml
{
    protected $path;
    protected static $xml;
    private $change = false;
    private static $src;

    public function __construct($path)
    {
        $this->path = $path;

    }

    protected function __clone(){ }

    protected function getInterfaceSrc()
    {
        $tmp = preg_split('/src/', __DIR__);
        $path = $tmp[0].'src/Yomaah/structureBundle/XML/TemplateAdmin/template.xml';
        if (!(isset(self::$src)))
        {
            self::$src = new \SimpleXmlElement(file_get_contents($path));
        }
        return self::$src;
    }


    private function singleXml()
    {
        if (!(isset(self::$xml)) || $this->change)
        {
            self::$xml = new \SimpleXmlElement(file_get_contents($this->path));
            if ($this->change)
            {
                $this->change = false;
            }
        }
        return self::$xml;
    }

    public function getFile($fullPath = null)
    {
        if ($fullPath === null)
        {
            return $this->singleXml();
        }else
        {
            if (preg_match('/\.xml/', $fullPath) === 0)
            {
                return false;
            }else
            {
                return new \SimpleXmlElement(file_get_contents($fullPath));
            }

        }
    }
    public function saveFile(\SimpleXmlElement $xml = null, $fullPath = null)
    {
        if ($fullPath === null && $xml === null)
        {
            $this->singleXml()->asXml($this->path);
            $this->change = true;
            
        }else if ($file !== null && get_class($xml) === 'SimpleXmlDocument')
        {
            if (file_exists($fullPath) === 0)
            {
                return false;
            }else
            {
                $xml->asXml($fullPath);
            }
        }
    }
    abstract function saveXml(\SimpleXmlElement $xml = null, $fullPath = null);
    abstract function getXml($fullPath = null);
}
