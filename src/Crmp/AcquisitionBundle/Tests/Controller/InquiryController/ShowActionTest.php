<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Tests\Controller\AuthTestCase;

class ShowActionTest extends AuthTestCase
{
    public function testUserCanAccessTheList()
    {
        /** @var Inquiry $someInquiry */
        $someInquiry = $this->getRandomEntity('CrmpAcquisitionBundle:Inquiry');

        $this->assertInstanceOf('\\Crmp\\AcquisitionBundle\\Entity\\Inquiry', $someInquiry);

        $client   = $this->createAuthorizedUserClient('GET', 'crmp_acquisition_inquiry_show', ['id' => $someInquiry->getId()]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertContains($someInquiry->getTitle(), $response->getContent());
    }
}