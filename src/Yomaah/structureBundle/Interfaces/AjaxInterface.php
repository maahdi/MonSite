<?php
namespace Yomaah\structureBundle\Interfaces;

interface AjaxInterface
{
    public function getAdminInterfaceAction(Array $param);
    public function getAdminContentStructureAction(Array $param);
    public function getRepoAdminContentList($object);
    public function getAdminContentAction(Array $param);
    public function getDialogAction(Array $param);
    public function addElementAction(Array $param);
    public function deleteElementAction(Array $param);
    public function saveElementAction(Array $param);
    public function uploadImageAction(Array $param);
    public function saveImageAction(Array $param);
    public function logoAdminStructureAction();
    public function deleteImageAction(Array $param);
}
