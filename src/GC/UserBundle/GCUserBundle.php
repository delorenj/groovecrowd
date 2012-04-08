<?php

namespace GC\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GCUserBundle extends Bundle
{
	public function getParent() {
		return 'FOSUserBundle';
	}
}
