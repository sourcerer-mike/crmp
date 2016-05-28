<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class EditActionTest extends AuthTestCase
{
    public function testUserCanEditAnAddress()
    {
        /** @var Inquiry $someInquiry */
        $someInquiry = $this->getRandomEntity('CrmpAcquisitionBundle:Inquiry');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Inquiry', $someInquiry);

        $routeParameters = ['id' => $someInquiry->getId()];
        $client          = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_inquiry_edit', $routeParameters);
        $response        = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someInquiry->getTitle(), $response->getContent());

        $this->assertRoute($client, 'crmp_acquisition_inquiry_edit', $routeParameters);
    }
}