<?php
namespace Yomaah\structureBundle\Entity;

use Yomaah\ajaxBundle\Classes\MyXml;

class KeywordsRepo extends MyXml
{
    public function __construct($path)
    {
        parent::__construct($path);
    }

    public function getGeneralKeywords()
    {
        $xml = $this->getByXpath('//keyworld');
        if ((bool) $xml)
        {
            return (string) $xml[0];
        }
    }
    public function getByXpath($xpath)
    {
        $xml = parent::getFile();
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

    public function save($keywords)
    {
        $xml = new \simpleXmlElement(file_get_contents($this->getXmlFilePath('keyword')));
        foreach($xml as $general)
        {
            $general->keywords = $keywords;
        }
        $xml->asXml($this->getXmlFilePath('keyword'));
    }
}
