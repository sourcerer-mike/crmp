<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class IndexActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $client = $this->createAuthorizedUserClient('GET', 'inquiry_index');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}