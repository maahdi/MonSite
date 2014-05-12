<?php
namespace Yomaah\ajaxBundle\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Controle les requetes en ajax et renvoie ce qui est démandé
 *
 **/
class AjaxController extends Controller
{
    public function updateArticleAction ()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        //if ($bundleDispatcher->isAdmin())
        //{
            if (!($bundleDispatcher->isTestSite()))
            {
                $request = $this->container->get('request');
                $article = $this->getDoctrine()->getRepository('yomaahBundle:Article')->find($request->request->get('id'));
                $getSet = $this->getSetterGetter($request->request->get('champ'));
                $content = $this->clearTitre($request->request->get('champ'), $request->request->get('content'));
            }else
            {
                $request = $this->get('request');
                $article = $this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')->find($request->request->get('id'));
                $getSet = $this->getSetterGetter($request->request->get('champ'));
                $content = $this->clearTitre($request->request->get('champ'), $request->request->get('content'));
                
            }
            if ($getSet !== false && $content != "")
            {
                //if ((substr_compare($article->$getSet['getter'](), $content, 0) != 0))
                //{
                    $article->$getSet['setter']($content);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($article);
                    $em->flush();
                    return new Response();

                //}else
                //{
                    //return new Response('Deja enregistré');
                //}
            }else if ($content == "")
            {
                return new Response('Le titre ne peut pas être vide !');
            }else
            {
                return new Response('Erreur : mauvais champ !');
            }
        //}

    }

    public function deleteArticleAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            if (!($bundleDispatcher->isTestSite()))
            {
                $request = $this->get('request');
                $em = $this->getDoctrine()->getManager();
                $em->remove($this->getDoctrine()->getRepository('yomaahBundle:Article')->find($request->request->get('id')));
                $em->flush();
                return new Response();

            }else
            {
                $request = $this->get('request');
                $em = $this->getDoctrine()->getManager();
                $em->remove($this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')->find($request->request->get('id')));
                $em->flush();
                return new Response();
            }
        }
    }

    public function getNewArticleAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $template = 'layoutArticle.html.twig';
            $bundle = 'YomaahajaxBundle:';
            if ($bundleDispatcher->isTestSite())
            {
                $token = $this->get('session')->get('testToken');
                $request = $this->get('request');
                $url = $request->request->get('page');
                $tmp = explode('test_',$url);
                $page = $this->get('doctrine')->getRepository('yomaahBundle:PageTest')->findOneBy(array('pageUrl' => $tmp[1],'token' => $token));
                $article = $this->getDoctrine()->getRepository('yomaahBundle:ArticleTest')
                            ->findDefaultArticle($request->request->get('position'),$tmp[1], $page, $token);
                
            }else
            {
                $request = $this->get('request');
                $url = $request->request->get('page');
                $tmp = explode('admin_',$url);
                $id = $bundleDispatcher->getIdSite();
                if ($bundleDispatcher->isClientSite())
                {
                    $template = 'layoutArticle'.$bundleDispatcher->getSite().'.html.twig';
                    $bundle = $bundleDispatcher->getControllerPath();
                }
                $page = $this->get('doctrine')->getRepository('yomaahBundle:Page')
                        ->findPageByUrl(array('pageUrl' => $bundleDispatcher->getSite().'_'.$tmp[1],'idSite' => $id));
                $param['page'] = $page;
                $param['idSite'] = $id;
                $param['position'] = $request->request->get('position');
                $article = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findDefaultArticle($param);
            } 
            return $this->container->get('templating')->renderResponse($bundle.'Ajax:'.$template, array('article' => $article));
        }
    }


    public function getDialogAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            if ($request->request->has('lien'))
            {
                $param['lien'] = $request->request->get('lien');
            }
            $param['dialog'] = $request->request->get('dialog');

            /** si on est sur le site client
             * les templates de dialogue des articles
             * sont appelés directement
             */
            if ($bundleDispatcher->isClientSite() && preg_match('/[a-zA-z]+Article/', $param['dialog']) === 1 
                    && preg_match('/newArticle/', $param['dialog']) === 0 && preg_match('/suppressionArticle/', $param['dialog']) === 0)
            {
                $template = $bundleDispatcher->getControllerPath().'Dialog:'.$param['dialog'].'.html.twig';
                return $this->container->get('templating')->renderResponse($template);

                /** idem qu'au dessus
                 * sauf qu'apellé depuis bundle principal
                 */
            }else if ($bundleDispatcher->isClientSite() && (preg_match('/newArticle/', $param['dialog']) === 1
                     || preg_match('/suppressionArticle/', $param['dialog']) === 1))
            {
                $template = 'YomaahajaxBundle:Ajax:'.$param['dialog'].'.html.twig';
                return $this->container->get('templating')->renderResponse($template);

            }else if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:getDialog', array('param' => $param));

            }else
            {
                $template = 'YomaahajaxBundle:Ajax:'.$param['dialog'].'.html.twig';
                return $this->container->get('templating')->renderResponse($template);
            }
        }
    }

    public function getAdminContentAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $param['lien'] = $request->query->get('lien');
            if ($bundleDispatcher->isClientSite() && preg_match('/pagesAdmin/', $param['lien']) === 0)
            {
                $param['id'] = $this->request->get('id');
                return $this->forward($bundleDispatcher->getControllerPath().'Main:getAdminContent', array('param' => $param));

            }else if (preg_match('/pagesAdmin/', $param['lien']))
            {
                $pages = $this->getDoctrine()->getRepository('yomaahBundle:Page')->findPage($bundleDispatcher->getIdSite());
                return new JsonResponse($pages);

            }
        }
    }

    public function getAdminContentStructureAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        $param = $this->get('request')->request->all();
        if ($bundleDispatcher->isAdmin())
        {
            if ($bundleDispatcher->isClientSite() && preg_match('/pagesAdmin/', $param['lien']) == 0)
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:getAdminContentStructure', array('param' => $param));

            }else if (preg_match('/pagesAdmin/', $param['lien']))
            {
                return new Response($this->getDoctrine()->getRepository('yomaahBundle:Page')->getHtml(null));

            }else
            {
                
                /**
                 * Pour le site principal
                 */
            }
        }else
        {
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:getAdminContentStructure', array('param' => $param));
            }
        }
    }
    public function atteindreAction()
    {
        $dispatcher = $this->get('bundleDispatcher');
        $request = $this->get('request');
        if ($dispatcher->isAdmin())
        {
            $param['lien'] = $request->request->get('lien');
            $tmp = explode('//', $request->getUri());
            $param['url'] = $tmp[0].'//'.$request->getHttpHost().$request->getBaseUrl();
            if ($dispatcher->isClientSite())
            {
                return $this->forward($dispatcher->getControllerPath().'Main:atteindre', array('param' => $param));
            }
        }
    }

    public function getAdminInterfaceAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $param = array();
            $param['lien'] = $request->request->get('lien');
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:getAdminInterface', array('param' => $param));

            }else
            {
                /**
                 * Pas de barre admin sur le site principal pour l'instant
                 **/
            }
        }
    }

    /**
     * Renvoie un tableau contenant les données et
     * en index leurs méthodes setter
     */
    static function decodeHtmlGet($encode)
    {
        if ($encode != null)
        {
            $elements = explode('&', $encode);
            $obj = array();
            foreach($elements as $e)
            {
                $tmp = explode('=',$e);
                if (preg_match('/date/',urldecode($tmp[0])) == 1)
                {
                    $date = preg_replace('/\//','-',urldecode($tmp[1]));
                    $obj['set'.ucfirst($tmp[0])] = new \Datetime($date);
                    
                }else
                {
                    if (!isset($tmp[1]))
                    {
                        $tmp[1] = '';
                    }
                    $obj['set'.ucfirst($tmp[0])] = urldecode($tmp[1]);
                }
            }
            return $obj;
        }
    }
    /**
     * Test si un élément exist
     * le récupere selon la méthode requise et applique une fonction dessus
     * Retourne false ou l'élément si un seul pattern
     * Retourne un tableau d'élément avec soit false soit la valeur
     */
    private function getRequestElement($request, $pattern, $method = 'POST', $function = null)
    {
        if ($method == 'POST')
        {
            $method = 'request';
        }else if ($method == 'GET')
        {
            $method = 'query';
        }
        if (is_array($pattern))
        {
            $result = array();
            foreach ($pattern as $key => $p)
            {
                if ($request->$method->has($p))
                {
                    $result[$key] = true;
                }else
                {
                    $result[$key] = false;
                }
            }
            foreach($result as $key => $val)
            {
                if ($val)
                {
                    if (!($function == null))
                    {
                        if (preg_match('/self/', $function))
                        {
                            $tmp = explode('self::', $function);
                            $param[$pattern[$key]] = self::$tmp[1]($request->$method->get($pattern[$key]));
                        }else
                        {
                            $param[$pattern[$key]] = $function($request->$method->get($pattern[$key]));
                        }
                    }else
                    {
                        $param[$pattern[$key]] = $request->$method->get($pattern[$key]);
                    }
                }else
                {
                    $param[$pattern[$key]] = false;
                }
            }
            return $param;
        }else
        {
            if ($request->$method->has($pattern))
            {
                return $request->$method->get($pattern);
            }else
            {
                return false;
            }
        }
    }

    public function saveElementAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $test = array('input', 'textarea');
            $field = $this->getRequestElement($request, $test, 'POST', 'self::decodeHtmlGet');
            $param['id'] = $request->request->get('id');
            $param['lien'] = $request->request->get('lien');
            $param = array_merge($field, $param);
            if ($bundleDispatcher->isClientSite() && preg_match('/pagesAdmin/', $param['lien']) == 0)
            {
                $test = array('active', 'inactive');
                $param = array_merge($param, $this->getRequestElement($request, $test));
                return $this->forward($bundleDispatcher->getControllerPath().'Main:saveElement', array('param' => $param));

            }else if ($bundleDispatcher->isClientSite() && preg_match('/pagesAdmin/', $param['lien']) == 1)
            {
                $page = $this->getDoctrine()->getRepository('yomaahBundle:Page')->find($param['id']); 
                $em = $this->getDoctrine()->getManager();
                if ($param['input'] != false)
                {
                    foreach($param['input'] as $key => $input)
                    {
                        $page->$key($input);
                    }
                }else if ($param['textarea'] != false)
                {
                    foreach($param['textarea'] as $key => $input)
                    {
                        $page->$key($input);
                    }
                }
                $em->persist($page);
                $em->flush();
                return new Response();
            }else
            {
                
            }
        }
    }

    public function deleteElementAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $param['id'] = $request->request->get('id');
            $param['lien'] = $request->request->get('lien');
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:deleteElement', array('param' => $param));
            }else
            {
                
            }
        }
    }

    public function addElementAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $param['lien'] = $request->query->get('lien');
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:addElement', array('param' => $param));
            }else
            {
                
            }
        }
    }

    private function clearTitre($champ, $content)
    {
        if ($champ == 'art-titre')
        {
            if (preg_match('/<br>/',$content))
            {
                $tmp = explode('<br>',$content);
                return $tmp[0];
            }else
            {
                return $content;
            }
        }else
        {
            return $content;
        }
    }

    private function getSetterGetter($champ)
    {
        switch ($champ)
        {
        case 'art-titre':
            $retour['getter'] = 'getArtTitle';
            $retour['setter'] = 'setArtTitle';
            break;
        case 'art-content':
            $retour['getter']= 'getArtcontent';
            $retour['setter'] = 'setArtContent';
            break;
        default:
            $retour = false;
        }
        return $retour;
    }

    static function imageSearch($dossier, $bundle)
    {
        $tmp = explode('src',__DIR__);
        $rootDir = $tmp[0].'src/'.$bundle.'/Resources/public/images/'.$dossier;

        $finder = new Finder();
        $f = $finder->depth('== 0')->files()->notname('/~$/')->in($rootDir);
        if (count($f) > 0)
        {
            $tmp = array();
            foreach ($f as $file)
            {
                $tmp[] = explode ($rootDir.'/', $file);
            }
            foreach ($tmp as $file)
            {
                $files[] = $file[1];
            }
            return $files;
        }else
        {
            return false;
        }
    }

    public function imagesSearchAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        $request = $this->get('request');
        $dossier = explode('Admin', $request->query->get('lien'));
        if ($bundleDispatcher->isAdmin())
        {
            if ($bundleDispatcher->isClientSite())
            {
                $images = self::imageSearch($dossier[0], $bundleDispatcher->getSitePath().'/'.$bundleDispatcher->getControllers());
            }else
            {
                $images = self::imageSearch($dossier[0], 'Yomaah/structureBundle');
            }
            return new JsonResponse($images);
        }
    }

    public function logoAdminStructureAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:logoAdminStructure');

            }else
            {
                
            }
        }
    }

    public function saveImageAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $param['lien'] = $request->request->get('lien');
            $param['id'] = $request->request->get('id');
            $param['png'] = $request->request->get('newPng');
            if (!(self::testNameValide($param['png'], 'png|jpg|jpeg')))
            {
                $param['png'] = false;
            }
            if (!(self::testNameValide($param['png'], 'png|jpg|jpeg')))
            {
                $param['png'] = false;
            }
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:saveImage', array('param' => $param));

            }else
            {
                
            }
        }
    }
    static function deleteImage($destination, $from, $file, $bundle)
    {
        exec ('mv ./bundles/'.$bundle.'/images/'.$from.$file.' ../deleted/'.$destination.time().$file);
    }

    static function moveImage($dossier1, $dossier2, $img, $bundle, $newImg = null)
    {
        if ($newImg === null)
        {
            exec('mv ./bundles/'.$bundle.'/images/'.$dossier1.$img.' ./bundles/'.$bundle.'/images/'.$dossier2.$img); 

        }else
        {
            exec('mv ./bundles/'.$bundle.'/images/'.$dossier1.$img.' ./bundles/'.$bundle.'/images/'.$dossier2.$newImg); 
        }
    }

    public function uploadImageAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $filename = $request->request->get('filename');
            $param['file'] = $request->files->get($filename);
            $param['lien'] = $request->query->get('lien');
            $pattern = array('maxSize', 'maxW', 'colorR', 'colorG', 'colorB', 'maxH');
            $param['fileInfo'] = $this->getRequestElement($request, $pattern, 'POST', 'strip_tags');
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:uploadImage', array('param' => $param));
                
            }else
            {
                
            }
        }
    }

    static function testFileExists($dossier, $file)
    {
        if (exec('ls '.$dossier.' | grep '.$file) == $file)
        {
            return true;
        }else
        {
            return false;
        }
    }
    static function testNameValide($name, $filtre)
    {
        if (preg_match('/([a-zA-Z0-9]+\-([a-zA-Z0-9]+|)|[a-zA-Z0-9]+)\.('.$filtre.')/', $name) == 1)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function deleteLogoAction()
    {
        $request = $this->get('request');
        return $this->forward('EuroLiteriestructureBundle:Main:deleteLogo', array('lien' => $request->request->get('lien'),
                                                                                  'png' => $request->request->get('png')));
    }

    static function uploadImage($fullPath, $file, $maxSize, $maxW, $folder, $colorR, $colorG, $colorB, $maxH = null, $resize = null){
		$maxlimit = $maxSize;
		$allowed_ext = "jpg,jpeg,png";
        $errorList = array();
		$match = "";
        $filesize = $file->getClientSize();
        $tmp = explode('/public/', $folder);
        $fullPath = '../../bundles/'.$fullPath.'/'.$tmp[1];
		if($filesize > 0){	
			$filename = strtolower($file->getClientOriginalName());
			$filename = preg_replace('/\s/', '_', $filename);
		   	if($filesize < 1){ 
				$errorList[] = "File size is empty.";
			}
			if($filesize > $maxlimit){ 
				$errorList[] = "File size is too big.";
			}
		    $file_ext = preg_split("/\./",$filename);
			$allowed_ext = preg_split("/\,/",$allowed_ext);
			foreach($allowed_ext as $ext){
				if($ext==end($file_ext)){
	   				$match = "1"; // File is allowed
					$NUM = time();
					$front_name = substr($file_ext[0], 0, 15);
					$newfilename = $filename;
					$filetype = end($file_ext);
					$save = $folder.$newfilename;
					if(!file_exists($save)){
						list($width_orig, $height_orig) = getimagesize($file->getPathName());
						if($maxH == null){
							if($width_orig < $maxW){
								$fwidth = $width_orig;
							}else{
								$fwidth = $maxW;
							}
							$ratio_orig = $width_orig/$height_orig;
							$fheight = $fwidth/$ratio_orig;
							
							$blank_height = $fheight;
							$top_offset = 0;
								
                        }else{
                            if ($resize)
                            {
                                $fwidth = $maxW;
                                $fheight = $maxH;
                            }else if($width_orig <= $maxW && $height_orig <= $maxH){
								$fheight = $height_orig;
								$fwidth = $width_orig;
                            }else{
								if($width_orig > $maxW){
									$ratio = ($width_orig / $maxW);
									$fwidth = $maxW;
									$fheight = ($height_orig / $ratio);
									if($fheight > $maxH){
										$ratio = ($fheight / $maxH);
										$fheight = $maxH;
										$fwidth = ($fwidth / $ratio);
									}
                                }
                                if($height_orig > $maxH){
									$ratio = ($height_orig / $maxH);
									$fheight = $maxH;
									$fwidth = ($width_orig / $ratio);
									if($fwidth > $maxW){
										$ratio = ($fwidth / $maxW);
										$fwidth = $maxW;
										$fheight = ($fheight / $ratio);
									}
								}
							}
							if($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0){
								die("FATAL ERROR REPORT ERROR CODE [add-pic-line-67-orig] to <a href='http://www.atwebresults.com'>AT WEB RESULTS</a>");
							}
							if($fheight < 45){
								$blank_height = 45;
								$top_offset = round(($blank_height - $fheight)/2);
							}else{
								$blank_height = $fheight;
							}
						}
						$image_p = imagecreatetruecolor($fwidth, $blank_height);
						$white = imagecolorallocate($image_p, $colorR, $colorG, $colorB);
						imagefill($image_p, 0, 0, $white);
						switch($filetype){
							case "gif":
								$image = @imagecreatefromgif($file->getPathName());
							break;
							case "jpg":
								$image = @imagecreatefromjpeg($file->getPathName());
							break;
							case "jpeg":
								$image = @imagecreatefromjpeg($file->getPathName());
							break;
							case "png":
								$image = @imagecreatefrompng($file->getPathName());
							break;
						}
						@imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
						switch($filetype){
							case "gif":
								if(!@imagegif($image_p, $save)){
									$errorList[]= "PERMISSION DENIED [GIF]";
								}
							break;
							case "jpg":
								if(!@imagejpeg($image_p, $save, 100)){
									$errorList[]= "PERMISSION DENIED [JPG]";
								}
							break;
							case "jpeg":
								if(!@imagejpeg($image_p, $save, 100)){
									$errorList[]= "PERMISSION DENIED [JPEG]";
								}
							break;
							case "png":
								if(!@imagepng($image_p, $save, 0)){
									$errorList[]= "PERMISSION DENIED [PNG]";
								}
							break;
						}
						@imagedestroy($filename);
					}else{
						$errorList[]= "CANNOT MAKE IMAGE IT ALREADY EXISTS";
					}	
				}
			}		
		}else{
			$errorList[]= "NO FILE SELECTED";
		}
		if(!$match){
		   	$errorList[]= "File type isn't allowed: $filename";
		}
		if(sizeof($errorList) == 0 && isset($errorList)){
			return $fullPath.$newfilename;
		}else{
			$eMessage = array();
			for ($x=0; $x<sizeof($errorList); $x++){
				$eMessage[] = $errorList[$x];
			}
		   	return $eMessage;
		}
	}

    public function deleteImageAction()
    {
        $bundleDispatcher = $this->get('bundleDispatcher');
        if ($bundleDispatcher->isAdmin())
        {
            $request = $this->get('request');
            $param['lien'] = $request->request->get('lien');
            $param['png'] = $request->request->get('png');
            if ($bundleDispatcher->isClientSite())
            {
                return $this->forward($bundleDispatcher->getControllerPath().'Main:deleteImage', array('param' => $param));
            }else
            {
                
            }
        }
    }

    public function getInterfaceAction()
    {
        $interface = $this->get('interfaceBuilder');
        return new Response($interface->getInterface()->getHtml());
    }
    /* GET */
    public function getInterfaceHtmlAction()
    {
        $id = $this->get('request')->query->get('id');
        $interface = $this->get('interfaceBuilder');
        $tmp = $interface->getNewForJson($id);
        return new JsonResponse($tmp);
    }
    //public function getContentAction()
    //{
        //$id = $this->get('request')->request->get('id');
        //$interface = $this->get('interfaceBuilder');
        //$interface->getToolBar('marques');
        //$interface->getDisplayContent();
    //}
}
