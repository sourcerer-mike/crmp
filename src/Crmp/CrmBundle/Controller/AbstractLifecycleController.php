<?php

namespace Crmp\CrmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractLifecycleController extends Controller {
	protected function updateLifecycle( $entity ) {
		$entity->setUpdatedBy( $this->getUser() );

		if ( ! $entity->getCreatedBy() ) {
			$entity->setCreatedBy( $this->getUser() );
		}
	}
}