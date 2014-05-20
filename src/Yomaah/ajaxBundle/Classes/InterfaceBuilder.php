<?php
namespace Yomaah\ajaxBundle\Classes;


class InterfaceBuilder
{
    private $confBuilder;
    private $displayContent;
    private $toolbar;

    public function __construct(ConfBuilder $builder)
    {
        $this->confBuilder = $builder;
        $this->displayContent = new DisplayContent($builder);
        $this->toolbar = new ToolBar($builder);
    }

    public function getNew($name, $id = null)
    {
        switch ($name)
        {
        case 'interface':
            $navbar = new NavBar();
            foreach ($this->getNavBarButtons() as $button)
            {
                $navbar->addElement(new Element('section', $button['title'], 'navBar-btn', array('id' => $button['id'])));
            }
            $this->displayContent->setDefaultDisplay();
            $layout = new AdminLayout($navbar, $this->toolbar,$this->displayContent);
            return $layout->getHtml();
            break;
        case 'online':
        case 'displayContent':
            $this->displayContent->set($this->getTypeDisplay($id), $this->getDisplayClass($id));
            $this->toolbar->set($this->getToolName($id), $this->getDisplayClass($id));
            $onglet = new Onglet($this->getDisplayTitle($id), $id, $this->getDisplayClass($id)); 
            return array('content' => $this->displayContent->getHtml(), 'toolbar' => $this->toolbar->getHtml(), 'onglet' => $onglet->getHtml());
            break;
        }
    }
    public function getToolName($id)
    {
        $name = $this->getByXpath('//navBar[@id="'.$id.'"]/toolBar/button[@class]');
        if ($this->testXpath($name))
        {
            if (is_array($name))
            {
                foreach ($name as $value)
                {
                    $tmp[] = (string) $value['class'];
                }
            }else
            {
                $tmp = (string) $name[0];
            }
            return $tmp;
        }
    }
    public function getDisplayTitle($id)
    {
        $title = $this->getByXpath('//navBar[@id="'.$id.'"]/title');
        if ($this->testXpath($title))
        {
            return (string) $title[0];
            
        }else
        {
            return false;
        }
    }

    public function getTypeDisplay($id)
    {
        $type = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/type');
        if ($this->testXpath($type))
        {
            return (string) $type[0];
        }
    }

    private function getNavBarButtons()
    {
        $conf = $this->loadConf();
        $tmp = array();
        $i = 0;
        foreach($conf->admin->navBar as $navBar)
        {
            $tmp[$i]['id'] = (string) $navBar['id'];
            $tmp[$i]['title'] = (string) $navBar->title;
            $i++;
        }
        return $tmp;
        
    }
    /* vieux code en dessous */

    public function newElement($name, $contains, $class = null, $attributs)
    {
        return new Element($name, $contains, $class, $attributs);
    }

    public function getNewToolBar($id)
    {
        $toolbar = new ToolBar($this->confBuilder);
        $name = $this->getToolName($id);
        return $toolbar->getNewToolBar($name)->getHtml();

    }

    public function getDisplayContentStructure($id)
    {
        $tmp['type'] = $this->getTypeDisplay($id);
        $tmp['html'] = $this->getTemplate($tmp['type'], $id);
        $tmp['srcUrl'] = $this->getSrcUrl($id);
        $tmp['script'] = $this->getScript($id);
        return $tmp;
    }


    public function getDisplayClass($id)
    {
        $class = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/distinctClass');
        if ($this->testXpath($class))
        {
            return (string) $class[0];
        }else
        {
            return false;
        }
    }

    public function testXpath($value)
    {
        if ((bool) $value)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function getScript($id)
    {
        $scripts = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/script');
        if ((bool) $scripts)
        {
            $script = (string) $scripts[0];
            return $this->confBuilder->getScript($script);
        }else
        {
            return false;
        }
    }

    public function getDossier($id)
    {
        $dossiers = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/dossiers/dossier');
        $retour = array();
        if ((bool) $dossiers)
        {
            foreach ($dossiers as $dossier)
            {
                $retour[(string) $dossier['src']] = (string) $dossier;
            }
        }
        return $retour;
    }

    public function getDragDropContent($files)
    {
        return $this->displayContent->getDragDropContent($files);
    }

    public function getTemplate($type, $id)
    {
        switch($type)
        {
        case 'online':
        case 'miniatured':
            $template = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/template');
            if ($this->testXpath($template))
            {
                return $this->confBuilder->getTemplate((string) $template[0]);
            }else
            {
                return false;
            }
            break;
        case 'dragDrop':
            return false;
            break;
        }
    }

    public function getSrcUrl($id)
    {
        $src = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/srcUrl');
        if ($this->testXpath($src))
        {
            return (string) $src[0];
        }else
        {
            return false;
        }
    }

    public function getInterfaceType($id)
    {
        return $this->getTypeDisplay($id);
        
    }

    public function getEntityName($id)
    {
        $retour = array();
        $retour['xml'] = false;
        if ((bool) $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/entity[@bundle]'))
        {
            $retour['clientBundle'] = false;
            $champ = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/entity[@champ]');
            $retour['champ'] = ((bool) $champ)?(string) $champ[0]['champ'] :false;
            $tag = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/entity[@tag]');
            $retour['tag'] = ((bool) $tag)?(string) $tag[0]['tag'] :false;
            
        }else
        {
            $retour['clientBundle'] = true;
        }
        if ((bool) $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/entity[@xml]'))
        {
            $retour['xml'] = true;
            if ((bool) $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/entity[@repo]'))
            {
                $tmp = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/repo');
                $retour['repo'] = (string) $tmp[0];
            }
        }
        $entity = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/entity');
        if ($this->testXpath($entity))
        {
            $retour['entity'] = (string) $entity[0];
        }
        return $retour;
    }

    public function getByXpath($xpath)
    {
        return $this->confBuilder->getByXpath($xpath);
    }

    public function loadConf()
    {
        return $this->confBuilder->getFile();
        
    }
}
