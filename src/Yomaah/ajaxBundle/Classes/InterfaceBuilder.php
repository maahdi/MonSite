<?php
namespace Yomaah\ajaxBundle\Classes;


class InterfaceBuilder
{
    private $confBuilder;

    public function __construct(ConfBuilder $builder)
    {
        $this->confBuilder = $builder;
    }

    public function newElement($name, $contains, $class = null, $attributs)
    {
        return new Element($name, $contains, $class, $attributs);
    }

    public function getNewForJson($id)
    {
        $class = $this->getByXpath('//navBar[@id="'.$id.'"]/displayContent/distinctClass');
        $title = $this->getByXpath('//navBar[@id="'.$id.'"]/title');
        $tmp = DisplayContent::getNewForJson((string) $class[0],(string) $title[0], $id);
        $retour['onglet'] = $tmp['onglet']->getHtml();
        $retour['content'] = $tmp['content']->getHtml();
        return $retour;
    }

    public function getInterface()
    {
        $tmp = array();
        $buttons = $this->getNavBarButtons();
        foreach ($buttons as $elem)
        {
            $tmp[] = new Element('section', $elem['title'], 'navBar-btn', array('id' => $elem['id']));
        }
        return new AdminLayout(new NavBar($tmp), new ToolBar(), new DisplayContent());
        
    }
    public function getToolBar($id)
    {
        $conf = $this->loadConf();
        $tmp = array();
        $murl = false;
        foreach($conf->admin->navBar as $navBar)
        {
            if ((string) $navBar['id'] == $id)
            {
                foreach($navBar->toolBar->button as $btn)
                {
                    $tmp[]= (string) $btn['class'];
                    if ((string) $btn['class'] == 'att-btn')
                    {
                        $murl = true;
                    }
                }
                if ($murl)
                {
                    $url = (string) $navBar->toolBar->url;
                }
            }
        }
        foreach ($tmp as $btn)
        {
            $tool = new Tool($btn);
            if ($btn == 'att-btn')
            {
                $tool->setAttributes('id', $url);
            }
            $tools[] = $tool;
        }
        //$p = 'keyworlds';
        //var_dump((string)$this->getByXpath('//'.$p)[0]);
        
    }
    public function getDisplayContent()
    {
        $nav = $this->getByXpath('//navBar[@id="magasin"]');
        foreach($nav as $html)
        {
        }
        
    }
    public function getNavBarButtons()
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
    public function getByXpath($xpath)
    {
        return $this->confBuilder->getByXpath($xpath);
    }

    public function loadConf()
    {
        return $this->confBuilder->getFile();
        
    }
}
