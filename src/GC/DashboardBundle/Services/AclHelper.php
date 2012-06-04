<?php
namespace GC\DashboardBundle\Services;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class AclHelper {

	protected $aclProvider;
	protected $securityContext;
	protected $logger;

    public function __construct(MutableAclProvider $aclProvider, $securityContext, $logger) {
    	$this->aclProvider = $aclProvider;
    	$this->securityContext = $securityContext;
    	$this->logger = $logger;
    }	

    public function bindUserToObject($object, $mask) {
      if(false === $this->securityContext->isGranted('ROLE_USER')) {
        $this->logger->info('No ACL: Anonymous');
      	return 0;
      } 	
      // creating the ACL
      $this->logger->info('Creating the ACL');
      $objectIdentity = ObjectIdentity::fromDomainObject($object);
      $acl = $this->aclProvider->createAcl($objectIdentity);

      // retrieving the security identity of the currently logged-in user
      $this->logger->info('Retrieving the security identity of the currently logged-in user');      
      $user = $this->securityContext->getToken()->getUser();
      $securityIdentity = UserSecurityIdentity::fromAccount($user);

      // grant owner access
      $this->logger->info('Grant owner access');            
      $acl->insertObjectAce($securityIdentity, $mask);
      $this->aclProvider->updateAcl($acl); 

      return 1;
    }

}