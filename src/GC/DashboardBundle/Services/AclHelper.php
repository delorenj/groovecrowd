<?php
namespace GC\DashboardBundle\Services;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use GC\DataLayerBundle\Helpers;

class AclHelper {

	protected $aclProvider;
	protected $securityContext;
	protected $logger;

	public function __construct(MutableAclProvider $aclProvider, $securityContext, $logger) {
		$this->logger = $logger;		
		$this->aclProvider = $aclProvider;
		$this->securityContext = $securityContext;
	}	

	public function bindUserToObject($object, $mask, $user = null) {
		if(!$user && false === $this->securityContext->isGranted('ROLE_USER')) {
			$this->logger->info('ACL:: No ACL: Anonymous');
			return 0;
		} 	
      // creating the ACL
		$this->logger->info('ACL:: Creating the ACL');
		$objectIdentity = ObjectIdentity::fromDomainObject($object);
		$acl = $this->aclProvider->createAcl($objectIdentity);

      // retrieving the security identity of the currently logged-in user
		$this->logger->info('ACL:: Retrieving the security identity of the currently logged-in user');

		if(!$user) {
			$this->get('logger')->info('ACL:: Getting ACL from session');
			$user = $this->securityContext->getToken()->getUser();	
			$securityIdentity = UserSecurityIdentity::fromAccount($user);
		} else {
			$this->logger->info('ACL:: Getting ACL from passed in parameter: ' . $user->getUsername());
			$securityIdentity = new UserSecurityIdentity(
                      	$user->getUsername(),
                        'GC\DataLayerBundle\Entity\User');			
		}
		
      // grant owner access
		$this->logger->info('ACL:: Grant owner access');
		$acl->insertObjectAce($securityIdentity, $mask);
		$this->aclProvider->updateAcl($acl); 

		return 1;
	}

	public function canDeleteAsset($asset, $claimed_id) {
		if(false === $this->securityContext->isGranted('ROLE_USER')) {
			$this->logger->info('No ACL: Anonymous Delete - checking asset/project relationship');
			$real_id = $asset->getProject()->getId();
			$this->logger->info('Real pid: ' . $real_id);
			$this->logger->info('Claimed pid: ' . $claimed_id);
			if(Helpers::codeToId($claimed_id) == $real_id) {
				$this->logger->info('IDs match - good to delete');
				return true;
			} else {
				$this->logger->info('IDs did not match - not allowed to delete');
				return false;
			}
		} else {
			if (false === $this->securityContext->isGranted('DELETE', $asset))
			{
				return false;
			} else {
				return true;
			}
		}
	}

	public function canEdit($object) {
		return (true === $this->securityContext->isGranted('EDIT', $object));
	}

}