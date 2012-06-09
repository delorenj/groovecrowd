<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use GC\DataLayerBundle\Helpers;
use GC\DataLayerBundle\Entity\ProjectAsset;

class AssetController extends Controller
{
   public function indexAction()
    {
  
    }

    public function uploadImageOrVideoAction(Request $request, $id) {

        /***
        /* Check for web asset
        /**/
        if($url = $request->request->get("url")) {
            // Download image
            $ext = Helpers::ShowFileExtension($url);        
            $filename = Helpers::ShowFileName($url) . "." . $ext;
            $tempFile = sys_get_temp_dir() . $filename;            
            file_put_contents($tempFile, file_get_contents($url));

        }

        /***
        /* If no web asset, check for file upload
        /**/
        else if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
            $this->get('logger')->info("ERROR: Filedata not found");
            return Helpers::buildJSONResponse(301, "Error uploading file");

        /***
        /* If here, upload was good, do upload stuff
        /**/            
        } else {
            $filename = preg_replace("/\s+/", "+", $request->request->get('Filename'));   
            $tempFile = $_FILES["Filedata"]["tmp_name"];
        }

        /***
        /* Set vars before translating params
        /**/
        $imgPathPrefix = "contest/" . $id . "/";
        $imgThumbPathPrefix = $imgPathPrefix . "thumbs/";
        $codified = false;      
        $em = $this->getDoctrine()->getEntityManager();
        $project_repo = $this->getDoctrine()->getRepository("GCDataLayerBundle:Project");
        $this->get('logger')->info("adding web media from url $url for project $id");
        $s3 = $this->get('aws_s3');

        if($s3->if_object_exists("groovecrowd", $imgPathPrefix . $filename)) {
            return Helpers::buildJSONResponse(301, "This file was uploaded already!");            
        }

        /***
        /*  Redirect if file uploaded was a video
        /**/
        if(!$filetype = exif_imagetype($tempFile)) {
            //Maybe a video?
            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $mimetype = finfo_file($finfo, $tempFile);
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


        /***
        /* If uploaded, Create img from filedata
        /**/
        try {
            switch($filetype) {
                case 1:
                    $img = imagecreatefromgif($tempFile);
                    imagegif($img, sys_get_temp_dir() . $filename);                    
                break;
                case 2:
                    $img = imagecreatefromjpeg($tempFile);
                    imagejpeg($img, sys_get_temp_dir() . $filename);                    
                break;
                case 3:
                    $img = imagecreatefrompng($tempFile);           
                    imagepng($img, sys_get_temp_dir() . $filename);                                        
                break;
                default:
                    return Helpers::buildJSONResponse(301, "Invalid image type");
            }           
        } catch(Exception $e) {
            return Helpers::buildJSONResponse(301, "Error creating image handle");
        }

        if (!$img) {        
            return Helpers::buildJSONResponse(301, "Could not create image handle");
        }



        /***
        /* If anonymous, translate code to id
        /**/
        if(false === $this->get('security.context')->isGranted('ROLE_USER')) {
            $this->get('logger')->info('ANONYMOUS UPLOAD DETECTED: ' . $id);
            if(preg_match("/^\d+$/", $id) == 1) {
                return Helpers::buildJSONResponse(301, "Invalid project id format");
            } else {
                $id = Helpers::codeToId($id);
                $codified = true;
                $this->get('logger')->info('Translated code: ' . $id);
            }
        } else {
            if(preg_match("/[A-Z]$/", $id) == 1) {
                $id = Helpers::codeToId($id);
                $codified = true;
                $this->get('logger')->info('Translated code: ' . $id);                
            }
        }

        /***
        /* Find project, or return error if project not found
        /**/
        if(!$project = $project_repo->find($id)) {
            if($codified) $id = Helpers::idToCode($id);
            return Helpers::buildJSONResponse(404, "Project not found: " . $id);
        }

        /***
        /* Create thumb from img
        /**/
        $thumb_img = $this->createThumbnail($img, 160, 110);

        try {
            switch($filetype) {
                case 1:
                    imagegif($thumb_img, sys_get_temp_dir() . "thumb-" . $filename);
                break;
                case 2:
                    $this->get('logger')->info('creating jpeg thumb: ' . "thumb-" . $filename);
                    imagejpeg($thumb_img, sys_get_temp_dir() . "thumb-" . $filename);
                break;
                case 3:
                    imagepng($thumb_img, sys_get_temp_dir() . "thumb-" . $filename);
                break;
                default:
            }           
        } catch(Exception $e) {
            return Helpers::buildJSONResponse(301, "Error creating image thumb handle");
        }

        /***
        /* Upload image and image thumb to Amazon S3 bucket
        /**/
        $full_response = $s3->create_object('groovecrowd', $imgPathPrefix . $filename, array(
            'fileUpload' => sys_get_temp_dir() . $filename,
            'acl' => \AmazonS3::ACL_PUBLIC
        ));

        $thumb_response = $s3->create_object('groovecrowd', $imgThumbPathPrefix . $filename, array(
            'fileUpload' => sys_get_temp_dir() . "thumb-" . $filename,
            'acl' => \AmazonS3::ACL_PUBLIC
        ));

        /***
        /* Retrive S3 object URLs for image and thumb image
        /**/
        $thumb_uri = $s3->get_object_url('groovecrowd', $imgThumbPathPrefix . $filename);
        $full_uri = $s3->get_object_url('groovecrowd', $imgPathPrefix . $filename);


        /***
        /* Persist image URLs to database and associate with project
        /**/
        $type = $this->getDoctrine()->getRepository('GCDataLayerBundle:AssetType')->findOneByName('image');
        $asset = new ProjectAsset();
        $asset->setAssetType($type);
        $asset->setUri($full_uri);
        $asset->setThumbUri($thumb_uri);
        $asset->setCreatedAt(new \DateTime('now'));
        $asset->setProject($project);
        $em->persist($asset);
        $em->flush();


        /***
        /* Bind asset to ACL if not anonymous
        /**/            
        $bound = $this->get('acl_helper')->bindUserToObject($asset, MaskBuilder::MASK_OWNER);

        $data = array(
            "uri" => $full_uri,
            "thumb" => $thumb_uri,
            "id" => $asset->getId());

        return Helpers::buildJSONResponse(200, "Image uploaded", $data);        

    }   

    public function deleteAction(Request $request, $id, $aid) {        
        $em = $this->getDoctrine()->getEntityManager();        
        $repo = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectAsset');
        $asset = $repo->find($aid);

        if($this->get('acl_helper')->canDeleteAsset($asset, $id)) {
            $s3 = $this->get('aws_s3');
            preg_match("/^http:\/\/groovecrowd.s3.amazonaws.com\/(.*)$/", $asset->getUri(), $matches);            
            $s3->delete_object('groovecrowd', $matches[1]);

            preg_match("/^http:\/\/groovecrowd.s3.amazonaws.com\/(.*)$/", $asset->getThumbUri(), $matches);            
            $s3->delete_object('groovecrowd', $matches[1]);

            $s3->delete_object('groovecrowd', $asset->getThumbUri());
            $em->remove($asset);  
            $em->flush();
            return new Response(json_encode(array("OK" => "1", "code" => 200, "msg" => "thanks")), 200);
        } else {
            return new Response(json_encode(array("OK" => "0", "code" => 300, "msg" => "Error deleting asset")), 300);
        }
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

        $thumb_img = ImageCreateTrueColor(160, 110);
        $white = imagecolorallocate($thumb_img, 255, 255, 255);
        if (!@imagefilledrectangle($thumb_img, 0, 0, $target_width-1, $target_height-1, $white)) {    // Fill the image white
            $this->get('logger')->info("ERROR:could not fill new image ");
            return null;
        }

        if (!@imagecopyresampled($thumb_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
            $this->get('logger')->info("ERROR:could not resize image");
            return null;
        }
        return $thumb_img;
    }


    protected function uploadVideoAction(Request $request, $id) {
        return Helpers::buildJSONResponse(301, "Not implemented yet!");
    }

}
