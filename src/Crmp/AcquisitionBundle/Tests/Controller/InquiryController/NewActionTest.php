<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;

use Crmp\AcquisitionBundle\Controller\InquiryController;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\AcquisitionBundle\Form\InquiryType;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class NewActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = InquiryController::class;

    public function testItAllowsSettingTheCustomerViaRequest()
    {
        $inquiry = new Inquiry();
        $inquiry->setStatus(0);
        $inquiredAt = new \DateTime();
        $inquiry->setInquiredAt($inquiredAt->format('Y-m-d'));

        $customerId = mt_rand(42, 1337);

        $customer = new Customer();
        $customer->setName(uniqid());

        $inquiry->setCustomer($customer);

        $customerRepository = $this->mockRepositoryService('crmp.customer.repository', CustomerRepository::class);

        $customerRepository->expects($this->once())
                           ->method('find')
                           ->with($customerId)
                           ->willReturn($customer);

        $this->expectForm(InquiryType::class, $inquiry);

        $this->controllerMock->newAction(new Request(['customer' => $customerId]));
    }

    public function testItCreatesTheInquiryForm()
    {
        $inquiry = new Inquiry();
        $inquiry->setStatus(0);

        $inquiredAt = new \DateTime();
        $inquiry->setInquiredAt($inquiredAt->format('Y-m-d'));

        $formMock = $this->expectForm(InquiryType::class, $inquiry);

        $expectedView = uniqid();
        $formMock->expects($this->once())
                 ->method('createView')
                 ->willReturn($expectedView);

        $this->expectRenderingWith(
            'CrmpAcquisitionBundle:Inquiry:new.html.twig',
            [
                'form' => $expectedView,
            ]
        );

        $this->controllerMock->newAction(new Request());
    }
}