<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\AcquisitionBundle\Controller\InquiryController;
use Crmp\AcquisitionBundle\CoreDomain\Inquiry\InquiryRepository;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Check if editing an inquiry can be made.
 *
 * @see     InquiryController::editAction()
 *
 * @package Crmp\AcquisitionBundle\Tests\Controller\InquiryController
 */
class EditActionTest extends AbstractControllerTestCase
{
    public function testFormWithInquiryWillBeCreated()
    {
        $inquiry = $this->getInquiryStub();

        /** @var InquiryController $controller */
        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $this->createDeleteFormMock();
        $this->createCreateFormMock();

        $this->expectRendering('inquiry', $inquiry, 'CrmpAcquisitionBundle:Inquiry:edit.html.twig');

        $controller->editAction($this->createMock(Request::class), $inquiry);
    }

    public function testUpdateWillBeDelegatedToRepository()
    {
        $inquiry = $this->getInquiryStub();

        /** @var InquiryController $controller */
        $controller = $this->controllerMock = $this->controllerBuilder->getMock();

        $this->controllerMock->expects($this->atLeastOnce())
                             ->method('get')
                             ->with('crmp.inquiry.repository')
                             ->willReturn(
                                 $repoMock = $this->createMock(InquiryRepository::class)
                             );

        $repoMock->expects($this->atLeastOnce())->method('update')->with($inquiry);

        $this->createDeleteFormMock();

        $createForm = $this->createCreateFormMock();
        $createForm->expects($this->atLeastOnce())
                   ->method('isSubmitted')
                   ->willReturn(true);

        $createForm->expects($this->atLeastOnce())
                   ->method('isValid')
                   ->willReturn(true);

        $this->controllerMock->expects($this->atLeastOnce())
                             ->method('redirectToRoute');

        $controller->editAction($this->createMock(Request::class), $inquiry);
    }

    /**
     * @return Inquiry
     */
    protected function getInquiryStub()
    {
        $inquiry = new Inquiry();
        $inquiry->setContent('the content');
        $inquiry->setTitle('title');
        $inquiry->setStatus(1337);
        $inquiry->setNetValue(44);

        return $inquiry;
    }

    protected function setUp()
    {
        $this->controllerClass = InquiryController::class;

        parent::setUp();

        $this->controllerBuilder->setMethods(
            [
                'createDeleteForm',
                'createForm',
                'get',
                'redirectToRoute',
                'render',
            ]
        );
    }
}
