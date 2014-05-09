<?php
namespace Yomaah\ajaxBundle\Classes;

abstract class MyXml
{
    protected $path;
    protected static $xml;
    private $change = false;

    public function __construct($path)
    {
        $this->path = $path;
    }
    protected function __clone(){ }

    private function singleXml($path)
    {
        if (!(isset(self::$xml)) || $this->change)
        {
            self::$xml = new \SimpleXmlElement(file_get_contents($path));
            if ($this->change)
            {
                $this->change = false;
            }
        }
        return self::$xml;
    }

    public function getFile($file = null)
    {
        if ($file === null)
        {
            return $this->singleXml($this->path);
        }else
        {
            if (preg_match('/\.xml/', $file) === 0)
                $file = $file.'.xml';

            return $this->singleXml($this->path.'/'.$file);
        }
    }
    public function saveFile(\SimpleXMLElement $xml, $file = null)
    {
        if ($file === null)
        {
            $xml->asXml($this->path);
            
        }else
        {
            if (preg_match('/\.xml/', $file) === 0)
                $file = $file.'.xml';

            $xml->asXml($this->path.'/'.$file);
            
        }
        $this->change = true;
    }
    abstract function saveXml(\SimpleXmlElement $xml, $file = null);
    abstract function getXml($file = null);
}
