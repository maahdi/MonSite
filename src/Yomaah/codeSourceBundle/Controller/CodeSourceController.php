<?php
namespace Yomaah\codeSourceBundle\Controller;

use Yomaah\codeSourceBundle\Classes\LigneRepo;
use Symfony\Component\Finder\Finder;

class CodeSourceController
{

    private $path = '';
    private $init = false;
    private $repo;
    private $rootDir = '';

    public function __construct()
    {
        $this->repo = new LigneRepo();
    }

    public function init($path)
    {
        $this->path = $path;
        $this->constructRootPath();
        $this->init = true;
    }

    //Définis le chemin d'accès du dossier src
    //pour parser son contenu par défaut
    private function constructRootPath()
    {
        $path = preg_split('/\/src/',__DIR__);
        $this->rootDir = $path[0].'/src/';
    }

    //retourne le template associer pour afficher une liste ou un fichier
    private function getTemplate()
    {
        if ($this->init)
        {
            if (preg_match('/.php/',$this->path))
            {
                return array('template' => 'YomaahcodeSourceBundle:CodeSource:fichier.html.twig'); 
            }else
            {
                return array('template' => 'YomaahcodeSourceBundle:CodeSource:dossier.html.twig');
            }
        }
        //else exception
    }

    //retourne soit le chemin d'accès du fichier + template + path entier
    public function getVariable()
    {
        if ($this->init)
        {
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

    private function getFileFromPath()
    {
        $tmpPaths = explode ('/', $this->path);
        $nb = count($tmpPaths);
        return $tmpPaths[$nb-1];
    }

    private function explodeFileFromPath()
    {
        $tmpPaths = explode ('/', $this->path);
        $nb = count($tmpPaths);
        $chaine = '';
        for ($i = 0; $i < $nb-2; $i++)
        {
            if ($i < $nb -3)
            {
                $chaine .= $tmpPaths[$i].'/';
            }else
            {
                $chaine .= $tmpPaths[$i];
            }
        }
        return $chaine;
    }

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
        fseek($fichier,1);
        $i = 0;
        $chaine ='';
        while (!feof($fichier))
        {
            $buffer = fgets($fichier,4096);
            if ($i == 0)
            {
                $i++;
                $chaine = '<?php'."\n";
            }else
            {
                $chaine .= $buffer;
            } 
        } 
        fclose($fichier);
        return $chaine;
    }
}
