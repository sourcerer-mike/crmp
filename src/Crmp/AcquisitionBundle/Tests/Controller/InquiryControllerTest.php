<?php

namespace Crmp\AcquisitionBundle\Tests\Controller;

use Crmp\CrmBundle\Tests\Controller\AuthTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InquiryControllerTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        $this->assertAvailableForUsers('inquiry_index');
    }
}
