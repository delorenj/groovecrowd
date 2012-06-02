<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use GC\DataLayerBundle\Helpers;
use GC\DataLayerBundle\Entity\ProjectAsset;

class AssetController extends Controller
{
   public function indexAction()
    {
  
    }

    public function uploadVideoAction(Request $request, $id) {
        return new Response(json_encode(array("responseCode"=>301)), "301");
    }


    public function uploadImageOrVideoAnonymousAction(Request $request, $code) {
        $id = Helpers::codeToId($code);
        $this->get('logger')->info('ANONYMOUS UPLOAD: pid=' . $id);
        return $this->uploadImageOrVideoAction($request, $id);
    }

    public function uploadImageOrVideoAction(Request $request, $id) {
        if($this->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
            $this->get('logger')->info('ANONYMOUS UPLOAD DETECTED: ' . $id);
            if(preg_match("/^\d+$/", $id) == 1) {
                $this->get('logger')->info('Id not codified - rejecting!');
                return new Response(json_encode(array("responseCode"=>301, "msg" => "Invalid code")), "301");
            } else {
                $imgPathPrefix = "contest/" . $id . "/";
                $id = Helpers::codeToId($id);
                $this->get('logger')->info('Translated code: ' . $id);
            }
        } else {
            $imgPathPrefix = "contest/" . $id . "/";            
        }
        
        $imgThumbPathPrefix = $imgPathPrefix . "thumbs/";                

        $em = $this->getDoctrine()->getEntityManager();
        $url = $request->request->get('url');
        $this->get('logger')->info("adding web media from url $url for project $id");


        $s3 = $this->get('aws_s3');

        // Check the upload
        if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
            $this->get('logger')->info("ERROR: Filedata not found");
            return new Response(json_encode(array("responseCode"=>304)), "304");
        }

        $filedata = $_FILES["Filedata"];
        $filename = preg_replace("/\s+/", "+", $request->request->get('Filename'));


        if(!$filetype = exif_imagetype($filedata["tmp_name"])) {
            //Maybe a video?
            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $mimetype = finfo_file($finfo, $filedata["tmp_name"]);
            finfo_close($finfo);            
            $this->get('logger')->info('finfo: ' . $mimetype);
            $majortype = explode('/', $mimetype);
            $majortype = $majortype[0];
            if($majortype == "video") {
                $this->get('logger')->info('Video found! forwarding to video processing controller');
                return $this->forward('GCDashboardBundle:Project:uploadVideoAsset', array('id' => $id));
            }
        }
        $this->get('logger')->info('filetype: ' . $filetype);

        try {
            switch($filetype) {
                case 1:
                    $img = imagecreatefromgif($filedata["tmp_name"]);
                    imagegif($img, sys_get_temp_dir() . $filename);                    
                break;
                case 2:
                    $img = imagecreatefromjpeg($filedata["tmp_name"]);
                    imagejpeg($img, sys_get_temp_dir() . $filename);                    
                break;
                case 3:
                    $img = imagecreatefrompng($filedata["tmp_name"]);           
                    imagepng($img, sys_get_temp_dir() . $filename);                                        
                break;
                default:
            }           
        } catch(Exception $e) {
            $this->get('logger')->info('Wtf?: ' . $e);
        }

        // Get the image and create a thumbnail

        if (!$img) {
            $this->get('logger')->info("ERROR:could not create image handle ");
            return new Response(json_encode(array("responseCode"=>304)), "304");
        }

        $new_img = $this->createThumbnail($img, 160, 110);

        try {
            switch($filetype) {
                case 1:
                    imagegif($new_img, sys_get_temp_dir() . "thumb-" . $filename);
                break;
                case 2:
                    $this->get('logger')->info('creating jpeg thumb: ' . "thumb-" . $filename);
                    imagejpeg($new_img, sys_get_temp_dir() . "thumb-" . $filename);
                break;
                case 3:
                    imagepng($new_img, sys_get_temp_dir() . "thumb-" . $filename);
                break;
                default:
            }           
        } catch(Exception $e) {
            $this->get('logger')->info('Wtf?: ' . $e);
        }


        $full_response = $s3->create_object('groovecrowd', $imgPathPrefix . $filename, array(
            'fileUpload' => sys_get_temp_dir() . $filename,
            'acl' => \AmazonS3::ACL_PUBLIC
        ));

        $thumb_response = $s3->create_object('groovecrowd', $imgThumbPathPrefix . $filename, array(
            'fileUpload' => sys_get_temp_dir() . "thumb-" . $filename,
            'acl' => \AmazonS3::ACL_PUBLIC
        ));

        $thumb_uri = $s3->get_object_url('groovecrowd', $imgThumbPathPrefix . $filename);
        $full_uri = $s3->get_object_url('groovecrowd', $imgPathPrefix . $filename);

        $repo = $this->getDoctrine()->getRepository("GCDataLayerBundle:Project");
        if($project = $repo->find($id)) {
            $type = $this->getDoctrine()->getRepository('GCDataLayerBundle:AssetType')->findOneByName('upload');
            $asset = new ProjectAsset();
            $asset->setAssetType($type);
            $asset->setUri($full_uri);
            $asset->setThumbUri($thumb_uri);
            $asset->setCreatedAt(new \DateTime('now'));
            $asset->setProject($project);
            $em->persist($asset);
            $em->flush();

            // TODO: Create late-binding ACL for all objects
            // // creating the ACL
            // $aclProvider = $this->get('security.acl.provider');
            // $objectIdentity = ObjectIdentity::fromDomainObject($asset);
            // $acl = $aclProvider->createAcl($objectIdentity);

            // // retrieving the security identity of the currently logged-in user
            // $securityContext = $this->get('security.context');
            // $user = $securityContext->getToken()->getUser();
            // $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // // grant owner access
            // $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            // $aclProvider->updateAcl($acl); 

            $code = 200;
        } else {
            $code = 404;
            $uri = null;
        }
        $this->get('logger')->info("Ajax request return: $code");
        $return = json_encode(array("responseCode"=>$code, "uri"=>$full_uri, "thumb"=>$thumb_uri, "id" => $asset->getId()));
        $return = new Response($return, $code); 

        return $return;
    }   

    public function deleteAsset(Request $request, $id) {
        return new Response(json_encode(array("responseCode"=>301)), "301");
    }

    protected function createThumbnail($img, $target_width, $target_height) {
        $width = imageSX($img);
        $height = imageSY($img);

        if (!$width || !$height) {
            $this->get('logger')->info("ERROR:Invalid width or height ");
            return null;
        }

        $target_ratio = $target_width / $target_height;
        $img_ratio = $width / $height;

        if ($target_ratio > $img_ratio) {
            $new_height = $target_height;
            $new_width = $img_ratio * $target_height;
        } else {
            $new_height = $target_width / $img_ratio;
            $new_width = $target_width;
        }

        if ($new_height > $target_height) {
            $new_height = $target_height;
        }
        if ($new_width > $target_width) {
            $new_height = $target_width;
        }

        $new_img = ImageCreateTrueColor(160, 110);
        $white = imagecolorallocate($new_img, 255, 255, 255);
        if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, $white)) {    // Fill the image white
            $this->get('logger')->info("ERROR:could not fill new image ");
            return null;
        }

        if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
            $this->get('logger')->info("ERROR:could not resize image");
            return null;
        }
        return $new_img;
    }

}
