<?php
namespace Yomaah\codeSourceBundle\Controller;

use Symfony\Component\Finder\Finder;

class CodeSourceController
{

    private $path = '';
    private $init = false;
    private $repo;
    private $rootDir = '';

    public function init($path)
    {
        $this->path = $path;
        $this->constructRootPath();
        $this->init = true;
    }
    /**
     * Définis le chemin d'accès du dossier src
     * pour parser son contenu par défaut
     *
    **/
    private function constructRootPath()
    {
        $path = preg_split('/\/src/',__DIR__);
        //$this->rootDir = $path[0].'/src/';
        $this->rootDir = '/srv/http/workspace/yomaah/Projet/';
    }

    /** 
     * retourne le template associer pour afficher une liste ou un fichier
     * Déterminé si le path contient un . == fichier
     *
     **/
    private function getTemplate()
    {
        if ($this->init)
        {
            if (preg_match('/\./',$this->path))
            {
                return array('template' => 'YomaahcodeSourceBundle:CodeSource:fichier.html.twig'); 
            }else
            {
                return array('template' => 'YomaahcodeSourceBundle:CodeSource:dossier.html.twig');
            }
        }
        //else exception
    }
    /**
     * Retourne :
     *      - soit le chemin d'accès du fichier décomposé pour faire les liens + template + path entier + le fichier
     *      - soit la même chose mais sans le fichier
     *
     **/
    public function getVariable()
    {
        if ($this->init)
        {
            $return = array();
            if (preg_match('/\./',$this->path))
            {
                return array_merge($this->getTemplate(),array('entirePath' => $this->path,'paths' => $this->explodePath(),'file' => $this->getFile()));
            }else
            {
                $finder = new Finder();
                $f = $finder->depth('== 0')->files()->notname('/~$/')->in($this->rootDir.$this->path);
                if (count($f) > 0)
                {
                    $tmp = array();
                    foreach ($f as $file)
                    {
                        $tmp[] = explode ($this->rootDir.$this->path.'/',$file);
                    }
                    foreach ($tmp as $file)
                    {
                        $files[] = $file[1];
                    }
                    $return['files'] = $files;
                }
                $finder = new Finder();
                $f = $finder->depth('== 0')->directories()->in($this->rootDir.$this->path);
                if (count($f) > 0)
                {
                    $tmp = array();
                    foreach ($f as $dir)
                    {
                        $tmp[] = explode ($this->rootDir.$this->path.'/',$dir);
                    }
                    foreach ($tmp as $dir)
                    {
                        $dirs[] = $dir[1];
                    }
                    $return['directories'] = $dirs;
                }
                return array_merge($return,$this->getTemplate(),array('entirePath' => $this->path,'paths' => $this->explodePath()));
            }
        }
        //else exception
    }


    /**
     * Retourne les éléments du path délimités par un /
     * Associe l'url correspondante
     * ex : path : Yomaah/structureBundle/fichier.php
     *      url['Yomaah'] = 'Yomaah'
     *      url['structureBundle'] = Yomaah/structureBundle
     *      url['fichier'] = Yomaah/structureBundle/fichier.php
     **/
    private function explodePath()
    {
        $tmpPaths = explode('/',$this->path);
        $nb = count($tmpPaths);
        $paths = array();
        for ($i = 0; $i < $nb;$i++)
        {
            if ($i == 0)
            {
                $paths[$i] = $tmpPaths[$i];
            }else
            {
                $paths[$i] = $paths[$i-1].'/'.$tmpPaths[$i];
            }
        }
        for ($i =0;$i < $nb; $i++)
        {
            $return[$tmpPaths[$i]] = $paths[$i];
        }
        return $return;
    }

    private function getFile()
    {
        $fichier = fopen($this->rootDir.$this->path,'r');
        $i = 0;
        $chaine ='';
        while (!feof($fichier))
        {
            $buffer = fgets($fichier,4096);
            $chaine .= $buffer;
        } 
        fclose($fichier);
        return $chaine;
    }
}
