<?php

namespace Crmp\AcquisitionBundle\Tests\Controller\InquiryController;


use Crmp\AcquisitionBundle\Controller\InquiryController;
use Crmp\AcquisitionBundle\Entity\Inquiry;
use Crmp\CrmBundle\CoreDomain\Customer\CustomerRepository;
use Crmp\CrmBundle\Entity\Customer;
use Crmp\CrmBundle\Tests\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Request;

class IndexActionTest extends AbstractControllerTestCase
{
    protected $controllerClass = InquiryController::class;

    public function testItCanFilterByCustomer()
    {
        $customerId = 42;
        $customer   = new Customer();
        $customer->setName(uniqid());

        $inquiry = new Inquiry();
        $inquiry->setCustomer($customer);

        $customerRepo = $this->getMockBuilder(CustomerRepository::class)
                             ->disableOriginalConstructor()
                             ->setMethods(['find'])
                             ->getMock();

        $customerRepo->expects($this->once())
                     ->method('find')
                     ->with($customerId)
                     ->willReturn($customer);

        $this->mockService('crmp.customer.repository', $customerRepo);

        $this->expectFindAllSimilar($inquiry);

        $this->controllerMock->indexAction(new Request(['customer' => $customerId]));
    }

    public function testItCanFilterByStatus()
    {
        $status = mt_rand(42, 1337);

        $inquiry = new Inquiry();
        $inquiry->setStatus($status);

        $this->expectFindAllSimilar($inquiry);

        $this->controllerMock->indexAction(new Request(['status' => $status]));
    }
}
