<?php

namespace GC\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use GC\DataLayerBundle\Entity\GrooveFlag;
use GC\DataLayerBundle\Helpers;

class GrooveController extends Controller
{
   public function updateAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        $grooveFlagRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:GrooveFlag');      
        $grooveRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Groove');      
        $projectRepo = $this->getDoctrine()->getRepository('GCDataLayerBundle:Project');

        if($request->isXmlHttpRequest()) {
            if($request->getMethod() == "PUT") {
                $payload = $request->getContent();
                if(!empty($payload)) {
                    $params = json_decode($payload, true);
                } else {
                    return new Response(json_encode(array("OK" => "0", "msg" => "Invalid groove post")), 500);            
                }
                $gid = $params["id"];  

                if(!$groove = $grooveRepo->find($gid)) {
                    throw $this->createNotFoundException('The groove does not exist: ' . $gid);
                }
                

                if(isset($params["flag"])) {
                    $flaggedAlready = $em->createQuery('SELECT COUNT(t.id) FROM GC\DataLayerBundle\Entity\GrooveFlag t WHERE t.user = :user AND t.groove = :groove')
                        ->setParameter('user', $user)
                        ->setParameter('groove', $groove)
                        ->getSingleScalarResult() > 0 ? 1 : 0;

                    if(!$flaggedAlready) {
                        $gf = new GrooveFlag();
                        $gf->setUser($user);                
                        $gf->setGroove($groove);
                        $gf->setCreatedAt(new \DateTime());
                        $em->persist($gf);                        
                    }
                }

                if(isset($params["rating"])) {
                    $canEdit = $this->get('acl_helper')->canEdit($groove->getProject()) ? "0":"1";       
                    $this->get('logger')->info('GROOVES: CanEdit=' . $canEdit);             
                    if($canEdit == "1") {
                        $this->get('logger')->info('GROOVES: CAN!');
                        $groove->setRating($params["rating"]);
                        $this->get('logger')->info('GROOVES: Setting rating=' . $params["rating"]);
                        $em->persist($groove);                        
                    }
                }
                $em->flush();
                return new Response(json_encode(array("OK" => 1)), 200);
            } else {
                return new Response(json_encode(array("OK" => "0", "msg" => "Invalid groove post")), 500);            
            }
        } else {
            return new Response(json_encode(array("OK" => "0", "msg" => "Invalid groove post")), 500);            
        }
    }
}
