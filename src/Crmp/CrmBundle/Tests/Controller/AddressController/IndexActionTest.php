<?php

namespace Crmp\CrmBundle\Tests\Controller\AddressController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->markTestSkipped('fails since User is an crmp entity. needs refactoring to proper unit tests');
    }
}
