<?php

namespace GC\DataLayerBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PriceMapRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PriceMapRepository extends EntityRepository
{

    public function getPackagePrice($project, $packageName) {
        return  $this->_em->createQuery('SELECT pm.price FROM GC\DataLayerBundle\Entity\PriceMap pm
            WHERE pm.project_type_id = :project_type_id AND pm.id = (SELECT p.id FROM GC\DataLayerBundle\Entity\Package p WHERE p.name = :package_name) ')
        ->setParameter('project_type_id', $project->getProjectType()->getId())
        ->setParameter('package_name', $packageName)
        ->getSingleScalarResult();
    }

    public function getPackagePrices($project) {
        return  $this->_em->createQuery('SELECT pm.price FROM GC\DataLayerBundle\Entity\PriceMap pm
            WHERE pm.project_type_id = :project_type_id')
        ->setParameter('project_type_id', $project->getProjectType()->getId())
        ->getResult();
    }

}