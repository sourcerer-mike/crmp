<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testLinksToNewAddress()
    {
        $client = $this->createAuthorizedUserClient();
    }
}