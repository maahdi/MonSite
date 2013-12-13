<?php

namespace Yomaah\structureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ForwardController extends Controller
{
    public function getMenuAction()
    {
        $mLeft = $this->getMenu('left');
        $mRight = $this->getMenu('right');
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $menu['left'] = $this->setAdminMenu($mLeft);
            $menu['right']= $this->setAdminMenu($mRight);
        }else
        {
            return array('left' => $mLeft,'Right' => $mRight);
        } 
    }

    private function setAdminMenu($menu)
    {
        foreach ($m in $menu)
        {
            $m->setPath('admin_'.$m->getPath());
        }
        return $menu;
    }

    private function getMenu($position)
    {
        if ($position == 'left')
        {
            return $this->getDoctrine()->getRepository('yomaahBundle:Menu')->getLeftMenu();
        }else if ($position == 'right')
        {
            return $this->getDoctrine()->getRepository('yomaahBundle:Menu')->getRightMenu();
        }
    }
}
