<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\AcquisitionBundle\Controller\InquiryController;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Tests\Controller\AbstractShowActionTest;

class ShowActionTest extends AbstractShowActionTest
{
    protected function setUp()
    {
        $this->controllerClass = InquiryController::class;

        parent::setUp();
    }

    public function testInquiryWillBeRendered()
    {
        $inquiry = new Inquiry();
        $inquiry->setTitle('the title');
        $inquiry->setContent('the content');

        $this->expectRendering('inquiry', $inquiry, 'CrmpAcquisitionBundle:Inquiry:show.html.twig');

        $this->controllerMock->showAction($inquiry);
    }
}