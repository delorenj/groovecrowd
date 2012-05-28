<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use GC\DataLayerBundle\Entity\User;
use GC\DataLayerBundle\Entity\Project;
use GC\DataLayerBundle\Entity\ProjectType;
use GC\DataLayerBundle\Entity\ProjectCreationProgress;
use GC\DataLayerBundle\Entity\ProjectAsset;
use GC\DataLayerBundle\Helpers;
use GC\DashboardBundle\Form\Type\ProjectDescriptionType;
use GC\DashboardBundle\Form\Type\PackageSelectionType;
use GC\DashboardBundle\Form\Type\PaymentType;

class ProjectController extends Controller
{

   public function indexAction()
    {
        return new Response("todo");
    }

    public function showAction($id) {
    	$project = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->find($id);

        return $this->render('GCDashboardBundle:Project:show.html.twig', 
        	array('project' => $project));
	}

	public function uploadVideoAssetAction(Request $request, $id) {
		return new Response(json_encode(array("responseCode"=>301)), "301");
	}

	public function uploadWebAssetAction(Request $request, $id) {
		$em = $this->getDoctrine()->getEntityManager();
		$url = $request->request->get('url');
		$this->get('logger')->info("adding web media from url $url for project $id");
		$s3 = $this->get('aws_s3');
		$imgPathPrefix = "contest/$id/";
		$imgThumbPathPrefix = $imgPathPrefix . "thumbs/";

		// Check the upload
		if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
			$this->get('logger')->info("ERROR: Filedata not found");
			return new Response(json_encode(array("responseCode"=>304)), "304");
		}

		$filedata = $_FILES["Filedata"];

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
				break;
				case 2:
					$img = imagecreatefromjpeg($filedata["tmp_name"]);
				break;
				case 3:
					$img = imagecreatefrompng($filedata["tmp_name"]);			
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

		$width = imageSX($img);
		$height = imageSY($img);

		if (!$width || !$height) {
			$this->get('logger')->info("ERROR:Invalid width or height ");
			return new Response(json_encode(array("responseCode"=>304)), "304");
		}

		// Build the thumbnail
		$target_width = 160;
		$target_height = 110;
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
		if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, $white)) {	// Fill the image white
			$this->get('logger')->info("ERROR:could not fill new image ");
			return new Response(json_encode(array("responseCode"=>304)), "304");
		}

		if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
			$this->get('logger')->info("ERROR:could not resize image");
			return new Response(json_encode(array("responseCode"=>304)), "304");
		}

		try {
			switch($filetype) {
				case 1:
					imagegif($new_img, sys_get_temp_dir() . "thumb-" . $request->request->get('Filename'));
				break;
				case 2:
					$this->get('logger')->info('creating jpeg thumb: ' . "thumb-" . $request->request->get('Filename'));
					imagejpeg($new_img, sys_get_temp_dir() . "thumb-" . $request->request->get('Filename'));
					$this->get('logger')->info('done');
				break;
				case 3:
					imagepng($new_img, sys_get_temp_dir() . "thumb-" . $request->request->get('Filename'));
				break;
				default:
			}			
		} catch(Exception $e) {
			$this->get('logger')->info('Wtf?: ' . $e);
		}


		$full_response = $s3->create_object('groovecrowd', $imgPathPrefix . $request->request->get('Filename'), array(
		    'fileUpload' => $filedata['tmp_name'],
		    'acl' => \AmazonS3::ACL_PUBLIC
		));

		$thumb_response = $s3->create_object('groovecrowd', $imgThumbPathPrefix . $request->request->get('Filename'), array(
		    'fileUpload' => sys_get_temp_dir() . "thumb-" . $request->request->get('Filename'),
		    'acl' => \AmazonS3::ACL_PUBLIC
		));

		$repo = $this->getDoctrine()->getRepository("GCDataLayerBundle:Project");
		if($project = $repo->find($id)) {
			$type = $this->getDoctrine()->getRepository('GCDataLayerBundle:AssetType')->findOneByName('web');
			$asset = new ProjectAsset();
			$asset->setAssetType($type);
			$asset->setUri($url);
			$asset->setCreatedAt(new \DateTime('now'));
			$asset->setProject($project);
			$em->persist($asset);
			$em->flush();
			$code = 200;
			$thumb_uri = $s3->get_object_url('groovecrowd', $imgThumbPathPrefix . $request->request->get('Filename'));
			$full_uri = $s3->get_object_url('groovecrowd', $imgPathPrefix . $request->request->get('Filename'));
		} else {
			$code = 404;
			$uri = null;
		}
		$this->get('logger')->info("Ajax request return: $code");
		$return = json_encode(array("responseCode"=>$code, "uri"=>$full_uri, "thumb"=>$thumb_uri));
		$return = new Response($return, $code);	

		return $return;
	}

	public function removeTagAction(Request $request, $id, $tag) {
		$this->get('logger')->info("removing tag $tag from project $id");
	 	$em = $this->getDoctrine()->getEntityManager();
		$repo = $this->getDoctrine()->getRepository("GCDataLayerBundle:Project");
		if($project = $repo->find($id)) {
				$repo->removeTag($project, $tag);
				$code = 200;				
		} else {
			$code = 404;
		}
		if ($request->isXmlHttpRequest()) {
			$return = json_encode(array("responseCode"=>$code));
			$return = new Response($return, $code);	
		} else {
			$return = json_encode(array("responseCode"=>304));
			$return = new Response($return, 304);	
		}
		return $return;
	}

	public function backAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();

		if($request->cookies->has('continueCode')) {
			$code = $request->cookies->get('continueCode');
			$this->get('logger')->info("FOUND CONTINUE CODE: " . $code);
			$progress = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectCreationProgress')->findOneByProject(Helpers::codeToId($code));			
			if(!$progress) {
				$return = $this->redirect('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));
				$cookie = new Cookie('continueCode','');
				$return->headers->setCookie($cookie);
				return $return;
			}			

			if($progress->getPhase() > 0) {
				$progress->setPhase($progress->getPhase()-1);
				$em->persist($progress);
				$em->flush();
			}
		}

		return $this->forward("GCDashboardBundle:Project:new", array("phase" => $progress->getPhase()));

	}

	public function newAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();
		$phase = 0;
		$project = $this->projectFromSession($request);
		$progress = $this->progressFromProject($project);
		if($redirect = $this->progressRedirect($progress, $phase)) {
			return $this->redirect($redirect);
		}

		if($request->getMethod() == "GET") {			
			return $this->render('GCDashboardBundle:Project:new.html.twig', 
				array("phase" => $phase));

		} else {
			$projectType = $request->request->get('projectType');
			$pt = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectType')->findOneBySlug($projectType);
			$project->setProjectType($pt);
			$em->persist($project);
			$progress->setPhase($phase+1);
			$progress->setProject($project);
			$em->persist($progress);
			$em->flush();
			return $this->redirect($this->generateUrl('project_category_select'));
		}
	}


	public function categorySelectAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();
		$phase = 1;
		$project = $this->projectFromSession($request);
		$progress = $this->progressFromProject($project);
		if($redirect = $this->progressRedirect($progress, $phase)) {
			return $this->redirect($redirect);
		}

		if($request->getMethod() == "GET") {
			return $this->render('GCDashboardBundle:Project:category_select.html.twig', array("phase" => $phase));	

		} else {
			$cat = $request->request->get('category');
			$cat = $em->getRepository('GCDataLayerBundle:Category')->findOneBySlug($cat);
			$project->setCategory($cat);
			$em->persist($project);
			$progress->setPhase($phase+1);
			$em->persist($progress);
			$em->flush();
			return $this->redirect($this->generateUrl('project_brief'));
		}
	}

	public function briefAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();
		$phase = 2;
		$project = $this->projectFromSession($request);
		$progress = $this->progressFromProject($project);
		if($redirect = $this->progressRedirect($progress, $phase)) {
			return $this->redirect($redirect);
		}

		$form = $this->createForm(new ProjectDescriptionType(), $project);
		$tags = $project->getTags();
		$t[] = null;
		foreach($tags as $tag) {
			$t[] = $tag->getName();
		}
		$tag_list = implode(',', $t);

		if($request->getMethod() == "GET") {
			return $this->render('GCDashboardBundle:Project:project_brief.html.twig', 
				array(	"phase" => $phase,
					 	"form" => $form->createView(), 
					 	"tag_list" => $tag_list, 
					 	"id" => $project->getId(),
					    'session' => array(
					        'name' => ini_get('session.name'),
					        'id' => session_id(),
					    ),					 	
					 	"assets" => $project->getAssets()));

		} else if($request->getMethod() == "POST") {
			$form->bindRequest($request);			
			if($form->isValid()) {
				$repo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Tag');
				$pd = $request->request->get('projectDescription');
				$tags = explode(',', $pd['tag_list']);
		        foreach($tags as $tag) {
		            $t = $repo->createIfNotExists($tag);
		            $project->addTag($t);
		        }
				$em->persist($project);
				$progress->setPhase($phase+1);
				$em->persist($progress);
				$em->flush();	
				return $this->redirect($this->generateUrl('project_package'));
			} else {
				return $this->render('GCDashboardBundle:Project:project_brief.html.twig', 
					array(	"phase" => $phase,
						 	"form" => $form->createView(), 
						 	"tag_list" => $tag_list, 
						 	"id" => $project->getId(),
						 	"assets" => $project->getAssets()));			
			}
		}
	}

	public function packageAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();
		$phase = 3;
		$project = $this->projectFromSession($request);
		$progress = $this->progressFromProject($project);
		if($redirect = $this->progressRedirect($progress, $phase)) {
			return $this->redirect($redirect);
		}

		$form = $this->createForm(new PackageSelectionType(), $project);
		$price_repo = $em->getRepository('GCDataLayerBundle:PriceMap');
		$prices = $price_repo->getPackagePrices($project);							
		if($request->getMethod() == "GET") {
			return $this->render('GCDashboardBundle:Project:package_select.html.twig', 
				array(	"id" => Helpers::idToCode($project->getId()), 
						"phase" => $phase, 
						"project" => $project, 
						"prices" => $prices, 
						"form" => $form->createView()));

		} else if($request->getMethod() == "POST") {
			$form->bindRequest($request);			
			if($form->isValid()) {
				$repo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Package');
				$packageName = $request->request->get('packageSelection');
				$packageName = $packageName['package'];
				$project->setPackage($repo->findOneBySlug($packageName));
				$em->persist($project);
				$progress->setPhase($phase+1);
				$em->persist($progress);
				$em->flush();
				return $this->redirect($this->generateUrl('project_payment'));
			} else {
				return $this->render('GCDashboardBundle:Project:package_select.html.twig', 
					array(	"id" => $code, 
							"phase" => $phase, 
							"project" => $project, 
							"prices" => $prices, 
							"form" => $form->createView()));
			}
		}
	}

	public function paymentAction(Request $request) {
		$em = $this->getDoctrine()->getEntityManager();
		$phase = 4;
		$project = $this->projectFromSession($request);
		$progress = $this->progressFromProject($project);
		if($redirect = $this->progressRedirect($progress, $phase)) {
			return $this->redirect($redirect);
		}

		$userManager = $this->container->get('fos_user.user_manager');					
    	$user = $this->get('security.context')->getToken()->getUser();
    	if($user == "anon.") {
    		$this->get('logger')->info('Creating User!');
    		$this->get('logger')->info('Anon: Creating a new user...');
    		$user = $userManager->createUser();
	        $user->setImage("default.jpg");				    		
    	}
		$project_repo = $em->getRepository('GCDataLayerBundle:Project');						
		$price = $project_repo->getPrice($project);	
		$csrf = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');														
		$form = $this->createForm(new PaymentType(), $user);
		
		if($request->getMethod() == "GET") {
			return $this->render('GCDashboardBundle:Project:payment.html.twig', 
				array(	"id" => Helpers::idToCode($project->getId()), 
						"phase" => $phase, 
						"user" => $user, 
			 			"project" => $project, 
			 			"price" => $price, 
			 			"csrf" => $csrf,
			 			"form" => $form->createView()));

		} else if($request->getMethod() == "POST") {
			$form->bindRequest($request);
			if($form->isValid()) {
		        if(!$user->hasRole('USER') &&	 !$user->hasRole('ROLE_CONSUMER')) {
		        	$this->get('logger')->info('User doesnt have role USER');
		        	$user->setEnabled(1);
		        	$user->addRole("ROLE_CONSUMER");
		        	$userManager->updateUser($user);
		        	$this->get('logger')->info('here');
		        }
				$progress->setPhase($phase);
				$em->persist($progress);
				$em->flush();
				$project->setEnabled(1);
				$project->setUser($user);
				$project->setCreatedAt(new \DateTime("now"));
				$project->setExpiresAt(new \DateTime("now + " . $project->getContestLength() . " day"));
				$em->persist($project);
				$em->flush();
				if($this->get('security.context')->getToken()->getUser() == "anon.") {
					$this->get('logger')->info("-------------------USER IS NOT LOGGED IN ------------------");
					$token = new UsernamePasswordToken($user, null, 'main', array('ROLE_USER'));
					$this->get('security.context')->setToken($token);
				}
				$return = $this->redirect($this->generateUrl('dashboard_index'));
				return $return;
			} else {
				return $this->render('GCDashboardBundle:Project:payment.html.twig', 
					array(	"id" => Helpers::idToCode($project->getId()), 
							"phase" => $phase, 
							"user" => $user, 
				 			"project" => $project, 
				 			"price" => $price, 
				 			"form" => $form->createView()));
			}
		}
	}

/**
*    Helpers
*		
**/

	protected function progressRedirect($progress, $phase) {
		if($progress == null) {
			$this->get('logger')->info('No progress found');
			return null;		
		}

		$this->get('logger')->info('Progress is currently set to \'' . $progress->getPhase() . '\' --> Trying to access phase ' . $phase);

		if($progress->getPhase() < $phase) {
			$this->get('logger')->info('Trying to access a phase that you haven\'t reached yet');
			switch($progress->getPhase()) {
				case '1':
					return $this->generateUrl('project_category_select');
				break;

				case '2':
					return $this->generateUrl('project_brief');			
				break;

				case '3':
					return $this->generateUrl('project_package_select');			
				break;

				case '4':
					return $this->generateUrl('project_payment');
				break;

				default:
					return $this->generateUrl('project_new');
			}
		} 

		return null;

	}

	protected function projectFromSession($request) {
		$em = $this->getDoctrine()->getEntityManager();
		$session = $request->getSession();
		if($code = $session->get("continueCode")) {
			$this->get('logger')->info("FOUND CONTINUE CODE IN SESSION: " . $code);
			if(!$project = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project')->find(Helpers::codeToId($code))) {
				$this->get('logger')->info('CODE FOUND, BUT PROJECT NOT...Creating a new one.');
				$project = new Project();
				$em->persist($project);
				$em->flush();
				$session->set("continueCode", Helpers::idToCode($project->getId()));
			}
		} else {
			$this->get('logger')->info("NO CODE: Create new form");
			$project = new Project();
			$em->persist($project);
			$em->flush();	
			$session->set("continueCode", Helpers::idToCode($project->getId()));
		}	
		return $project;
	}

    protected function projectFromCookie() {
		if($request->cookies->has('continueCode')) {
			$code = $request->cookies->get('continueCode');
			$this->get('logger')->info("FOUND CONTINUE CODE IN COOKIE: " . $code);
			$progress = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectCreationProgress')->findOneByProject(Helpers::codeToId($code));			
			if(!$progress) {
				$return = $this->render('GCDashboardBundle:Project:new.html.twig', array("phase" => 0));
				$cookie = new Cookie('continueCode','');
				$return->headers->setCookie($cookie);
			}
			$project = $progress->getProject();
    	} else {
    		return null;
    	}
	}

	protected function progressFromProject($project) {
		if(!$progress = $this->getDoctrine()->getRepository('GCDataLayerBundle:ProjectCreationProgress')->findOneByProject($project->getId())) {
			$em = $this->getDoctrine()->getEntityManager();
			$progress = new ProjectCreationProgress();
			$progress->setPhase(0);
			$em->persist($progress);
			$em->flush();
		}
		return $progress;
	}

     /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     */
    protected function authenticateUser(UserInterface $user)
    {
        try {
            $this->container->get('fos_user.user_checker')->checkPostAuth($user);
        } catch (AccountStatusException $e) {
            // Don't authenticate locked, disabled or expired users
            return;
        }

        $providerKey = $this->container->getParameter('fos_user.firewall_name');
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->get('logger')->info("AUTH TOKEN: " . $token);
        $this->container->get('security.context')->setToken($token);
    }

}