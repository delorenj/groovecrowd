<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
    public function find($id) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p FROM GCDataLayerBundle:Project p
                WHERE p.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1);
        try {
            $project = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        $this->formatProject($project);
        return $project;

    }

    public function findAllActiveProjects($user) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p, u FROM GCDataLayerBundle:Project p
                JOIN p.user u
                WHERE p.user = :user
                AND p.enabled=1
                AND p.expiresAt > :now'
            )->setParameter('user', $user)
            ->setParameter('now', new \DateTime('now'));

        try {
            $projects = $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        $this->formatProjects($projects);
        return $projects;
    }

    public function getGrooveCount($project) {
        return  $this->_em->createQuery('SELECT COUNT(g.id) FROM GC\DataLayerBundle\Entity\Groove g 
        	JOIN g.grooveSet gs WHERE gs.project = :project')
        ->setParameter('project', $project)
        ->getSingleScalarResult();
    }

    public function getContestEndDate($project) {
        $then = new \DateTime($project->getCreatedAt() + $project->getContestLength());
        return $then;
    }

    public function getPayoutAmount($project) {
        return  $this->_em->createQuery('SELECT pm.payout FROM GC\DataLayerBundle\Entity\PriceMap pm 
        	WHERE pm.project_type_id = :project_type_id AND pm.package_id = :package_id')
        ->setParameter('project_type_id', $project->getProjectType()->getId())
        ->setParameter('package_id', $project->getPackage()->getId())
        ->getSingleScalarResult();
    }

    public function getPrice($project) {
        $basePrice = $this->_em->createQuery('SELECT pm.price FROM GC\DataLayerBundle\Entity\PriceMap pm 
            WHERE pm.project_type_id = :project_type_id AND pm.package_id = :package_id')
        ->setParameter('project_type_id', $project->getProjectType()->getId())
        ->setParameter('package_id', $project->getPackage()->getId())
        ->getSingleScalarResult();

        if($project->getProtection() == true) {
            $basePrice += 40;
        }

        return $basePrice;
    }

    public function removeTag($project, $tagName) {
        if($tag= $this->_em->getRepository('GCDataLayerBundle:Tag')->findOneByName($tagName)) {            
            $q = $this->getEntityManager()
                           ->getConnection()
                           ->prepare('DELETE FROM project_tag WHERE project_id = ' . $project->getId() . ' AND tag_id = ' . $tag->getId());
              $q->execute();
              return 1;         
        } else {
            return 0;
        }
    }


/**
* Helpers
**/
    protected function formatProjects(&$projects) {
        if(!$projects) {
            return null;
        }

        foreach($projects as &$p) {
            $this->formatProject($p);
        }
    }

    protected function formatProject(&$p) {
        if(!$p->isEnabled()) {
            return ;
        }
        if($p->getExpiresAt()) {
            $then = strtotime($p->getExpiresAt()->format('Y-m-d H:i:s'));
            $datediff = $then - time();
            $p->secondsRemaining = $datediff;
            $p->percentComplete = 100-($p->secondsRemaining/($p->getContestLength()*60*60*24))*100;
        }

        $p->payoutAmount = $this->getPayoutAmount($p);
        $p->grooveCount = $this->getGrooveCount($p);        

    }
}